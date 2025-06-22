import sys
import os
import cv2
import numpy as np
import pickle
from PIL import Image

# Validasi input
if len(sys.argv) < 2:
    print("[ERROR] Harap sertakan path file/folder NIS (digunakan untuk lokasi base folder).")
    sys.exit(1)

nis_file = sys.argv[1]
faces_base_dir = os.path.dirname(nis_file)
print(f"[INFO] Base folder: {faces_base_dir}")

# Path ke folder model
model_folder = os.path.join(faces_base_dir, 'face_models')
os.makedirs(model_folder, exist_ok=True)

model_file = os.path.join(model_folder, 'traineer.yml')
label_file = os.path.join(model_folder, 'labels_map.pkl')

# Inisialisasi face detector & recognizer
face_frontal = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
face_profile = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_profileface.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()

# Penampung data training
faces = []
ids = []
label_ids = {}
current_id = 0

# Loop folder siswa
for folder_name in os.listdir(faces_base_dir):
    user_folder = os.path.join(faces_base_dir, folder_name)

    # Skip jika bukan folder, atau folder model
    if not os.path.isdir(user_folder) or folder_name == 'face_models':
        continue

    nis = folder_name.strip()
    if nis == "":
        continue

    # Buat mapping NIS → ID unik
    if nis not in label_ids:
        label_ids[nis] = current_id
        print(f"[INFO] Mapping NIS {nis} ke ID {current_id}")
        current_id += 1
    user_id = label_ids[nis]

    image_files = [f for f in os.listdir(user_folder) if f.lower().endswith(('.png', '.jpg', '.jpeg'))]
    print(f"[INFO] {nis} - Jumlah gambar ditemukan: {len(image_files)}")

    for filename in sorted(image_files):
        path = os.path.join(user_folder, filename)
        try:
            img = Image.open(path).convert('L')  # Grayscale
            img_np = np.array(img, 'uint8')

            # Preprocessing
            img_np = cv2.equalizeHist(img_np)
            img_np = cv2.GaussianBlur(img_np, (3, 3), 0)

            detected = False  # Flag apakah wajah ditemukan

            # 1. Deteksi frontal
            faces_detected = face_frontal.detectMultiScale(img_np, scaleFactor=1.1, minNeighbors=4, minSize=(50, 50))
            if len(faces_detected) > 0:
                for (x, y, w, h) in faces_detected:
                    face_roi = img_np[y:y+h, x:x+w]
                    face_roi = cv2.resize(face_roi, (200, 200))
                    faces.append(face_roi)
                    ids.append(user_id)
                    detected = True

            # 2. Deteksi profile kanan
            if not detected:
                faces_profile = face_profile.detectMultiScale(img_np, scaleFactor=1.1, minNeighbors=4, minSize=(50, 50))
                for (x, y, w, h) in faces_profile:
                    face_roi = img_np[y:y+h, x:x+w]
                    face_roi = cv2.resize(face_roi, (200, 200))
                    faces.append(face_roi)
                    ids.append(user_id)
                    detected = True

            # 3. Deteksi profile kiri (flip image)
            if not detected:
                flipped = cv2.flip(img_np, 1)
                faces_flipped = face_profile.detectMultiScale(flipped, scaleFactor=1.1, minNeighbors=4, minSize=(50, 50))
                for (x, y, w, h) in faces_flipped:
                    x_orig = img_np.shape[1] - x - w  # Konversi koordinat x hasil flip
                    face_roi = img_np[y:y+h, x_orig:x_orig+w]
                    face_roi = cv2.resize(face_roi, (200, 200))
                    faces.append(face_roi)
                    ids.append(user_id)
                    detected = True

            if not detected:
                print(f"[WARNING] Tidak ada wajah ditemukan di {filename}")

        except Exception as e:
            print(f"[WARNING] Gagal memproses {filename} untuk {nis}: {e}")

print(f"[INFO] Total wajah valid untuk training: {len(faces)}")

if not faces:
    print("[ERROR] Tidak ada data wajah yang layak untuk training.")
    sys.exit(1)

# Training model
recognizer.train(faces, np.array(ids))
recognizer.save(model_file)
print(f"[INFO] Model disimpan di: {model_file}")

# Simpan mapping label
with open(label_file, 'wb') as f:
    pickle.dump(label_ids, f)
print(f"[INFO] Label mapping disimpan di: {label_file}")
