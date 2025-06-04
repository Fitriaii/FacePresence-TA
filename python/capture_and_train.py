import sys
import os
import cv2
import numpy as np
import pickle
from PIL import Image

# Ambil path file NIS dari argumen
if len(sys.argv) < 2:
    print("[ERROR] Harap sertakan path file NIS.")
    sys.exit(1)

nis_file = sys.argv[1]
print(f"[DEBUG] Path file NIS: {nis_file}")

if not os.path.exists(nis_file):
    print("[ERROR] File NIS tidak ditemukan.")
    sys.exit(1)

with open(nis_file, 'r') as f:
    nis = f.read().strip()

if not nis:
    print("[ERROR] NIS kosong.")
    sys.exit(1)

print(f"[INFO] Training untuk NIS: {nis}")

# Setup path
base_dir = os.path.dirname(nis_file)
user_folder = os.path.join(base_dir, nis)
model_folder = os.path.join(base_dir, 'face_models')

os.makedirs(model_folder, exist_ok=True)

model_file = os.path.join(model_folder, f'{nis}_model.yml')
label_file = os.path.join(model_folder, f'{nis}_labels.pkl')

# Inisialisasi model
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()

faces = []
ids = []

image_files = [f for f in os.listdir(user_folder) if f.endswith('.png')]
if not image_files:
    print("[ERROR] Tidak ada gambar ditemukan untuk training.")
    sys.exit(1)

for filename in sorted(image_files):
    path = os.path.join(user_folder, filename)
    img = Image.open(path).convert('L')
    img_np = np.array(img, 'uint8')

    detected_faces = face_cascade.detectMultiScale(img_np, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

    for (x, y, w, h) in detected_faces:
        face_roi = img_np[y:y+h, x:x+w]
        faces.append(face_roi)
        ids.append(int(nis))

print(f"[INFO] Jumlah wajah terdeteksi: {len(faces)}")

if not faces:
    print("[ERROR] Tidak ada wajah terdeteksi untuk training.")
    sys.exit(1)

recognizer.train(faces, np.array(ids))
recognizer.save(model_file)

labels = {nis: model_file}
with open(label_file, 'wb') as f:
    pickle.dump(labels, f)

print(f"[INFO] Model disimpan di: {model_file}")
print(f"[INFO] Labels disimpan di: {label_file}")
