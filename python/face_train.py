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

# Path ke folder gambar siswa dan model
faces_base_dir = os.path.join(os.path.dirname(nis_file))
user_folder = os.path.join(faces_base_dir, nis)
model_folder = os.path.join(faces_base_dir, 'face_models')
os.makedirs(model_folder, exist_ok=True)

model_file = os.path.join(model_folder, 'traineer.yml')
label_file = os.path.join(model_folder, 'labels_map.pkl')

# Inisialisasi detektor dan recognizer
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()

faces = []
ids = []
label_ids = {nis: 0}  # Hanya satu user
user_id = 0

if not os.path.isdir(user_folder):
    print(f"[ERROR] Folder wajah untuk NIS {nis} tidak ditemukan: {user_folder}")
    sys.exit(1)

image_files = [f for f in os.listdir(user_folder) if f.endswith('.png')]
print(f"[DEBUG] Jumlah gambar ditemukan: {len(image_files)}")

for filename in sorted(image_files):
    path = os.path.join(user_folder, filename)
    try:
        img = Image.open(path).convert('L')  # Ubah ke grayscale
        img_np = np.array(img, 'uint8')

        # Perbaikan kualitas gambar
        img_np = cv2.equalizeHist(img_np)
        img_np = cv2.GaussianBlur(img_np, (3, 3), 0)

        faces_detected = face_cascade.detectMultiScale(
            img_np,
            scaleFactor=1.05,
            minNeighbors=3,
            minSize=(30, 30)
        )

        print(f"[DEBUG] {filename} - Wajah terdeteksi: {len(faces_detected)}")

        for (x, y, w, h) in faces_detected:
            face_roi = img_np[y:y+h, x:x+w]
            faces.append(face_roi)
            ids.append(user_id)

    except Exception as e:
        print(f"[WARNING] Gagal memproses file {filename} untuk NIS {nis}: {e}")

print(f"[INFO] Total wajah terdeteksi: {len(faces)}")
if not faces:
    print("[ERROR] Tidak ada wajah yang valid terdeteksi.")
    sys.exit(1)

# Training model
recognizer.train(faces, np.array(ids))
recognizer.save(model_file)

# Simpan label mapping
with open(label_file, 'wb') as f:
    pickle.dump(label_ids, f)

print(f"[INFO] Model disimpan di: {model_file}")
print(f"[INFO] Labels disimpan di: {label_file}")
