import sys
import os
import cv2
import numpy as np
import pickle
from PIL import Image

# Ambil base directory dari argumen
data_path = "storage/app/public/faces/"

# base_dir = sys.argv[1]
# print(f"[DEBUG] Base directory: {base_dir}")

# if not os.path.exists(base_dir):
#     print("[ERROR] Direktori tidak ditemukan.")
#     sys.exit(1)

# Setup path
model_folder = os.path.join(data_path, 'face_models')
os.makedirs(model_folder, exist_ok=True)

model_file = os.path.join(model_folder, "global_model.yml")
label_file = os.path.join(model_folder, "global_labels.pkl")

# Inisialisasi model
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()

faces = []
ids = []
label_map = {}
id_counter = 0

# Cari semua folder pengguna (setiap folder = satu pengguna)
user_folders = [f for f in os.listdir(data_path)
                if os.path.isdir(os.path.join(data_path, f))
                and f != 'face_models']

if not user_folders:
    print("[ERROR] Tidak ada folder pengguna ditemukan.")
    sys.exit(1)

# Loop melalui semua pengguna
for user_folder in user_folders:
    user_path = os.path.join(data_path, user_folder)

    # Skip jika bukan direktori
    if not os.path.isdir(user_path):
        continue

    print(f"[INFO] Memproses pengguna: {user_folder}")

    # Mapping ID unik untuk pengguna
    user_id = id_counter
    id_counter += 1
    label_map[user_id] = user_folder

    # Proses semua gambar di folder pengguna
    image_files = [f for f in os.listdir(user_path) if f.endswith(('.png', '.jpg', '.jpeg'))]

    for filename in sorted(image_files):
        path = os.path.join(user_path, filename)
        try:
            img = Image.open(path).convert('L')
            img_np = np.array(img, 'uint8')

            detected_faces = face_cascade.detectMultiScale(
                img_np,
                scaleFactor=1.1,
                minNeighbors=5,
                minSize=(30, 30)
            )

            for (x, y, w, h) in detected_faces:
                face_roi = img_np[y:y+h, x:x+w]
                faces.append(face_roi)
                ids.append(user_id)

        except Exception as e:
            print(f"[WARNING] Gagal memproses {filename}: {str(e)}")

print(f"[INFO] Total wajah terdeteksi: {len(faces)}")
print(f"[INFO] Total pengguna: {len(label_map)}")

if not faces:
    print("[ERROR] Tidak ada wajah terdeteksi untuk training.")
    sys.exit(1)

# Train dan simpan model global
recognizer.train(faces, np.array(ids))
recognizer.save(model_file)

# Simpan label map global
with open(label_file, 'wb') as f:
    pickle.dump(label_map, f)

print(f"[SUCCESS] Model global disimpan di: {model_file}")
print(f"[SUCCESS] Label map disimpan di: {label_file}")
