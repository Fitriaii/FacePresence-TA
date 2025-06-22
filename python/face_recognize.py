import sys
import os
import cv2
import pickle

# Cek input
if len(sys.argv) < 2:
    print("[ERROR] Harap sertakan path gambar untuk dikenali.")
    sys.exit(1)

image_path = sys.argv[1]

if not os.path.exists(image_path):
    print("[ERROR] File gambar tidak ditemukan.")
    sys.exit(1)

# Tentukan lokasi model dan label
base_dir = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', 'storage', 'app', 'public', 'faces', 'face_models'))
model_file = os.path.join(base_dir, 'traineer.yml')
label_file = os.path.join(base_dir, 'labels_map.pkl')

if not os.path.exists(model_file) or not os.path.exists(label_file):
    print("[ERROR] Model atau file label tidak ditemukan.")
    sys.exit(1)

# Load model
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read(model_file)

# Load label mapping
with open(label_file, 'rb') as f:
    label_ids = pickle.load(f)
    reverse_labels = {v: k for k, v in label_ids.items()}

# Baca gambar input
image = cv2.imread(image_path, cv2.IMREAD_GRAYSCALE)
if image is None:
    print("[ERROR] Gagal membaca gambar.")
    sys.exit(1)

# Deteksi wajah
faces = face_cascade.detectMultiScale(image, scaleFactor=1.1, minNeighbors=5, minSize=(50, 50))

if len(faces) == 0:
    print("[INFO] Tidak ada wajah ditemukan.")
    print("Wajah tidak ditemukan.")
    sys.exit(0)

# Ambil wajah pertama saja (jika multiple, kamu bisa loop juga)
(x, y, w, h) = faces[0]
face_roi = image[y:y+h, x:x+w]

# Preprocessing (sama seperti training)
face_roi = cv2.equalizeHist(face_roi)
face_roi = cv2.GaussianBlur(face_roi, (3, 3), 0)
face_roi = cv2.resize(face_roi, (200, 200))

# Prediksi
try:
    id_, confidence = recognizer.predict(face_roi)
    print(f"[DEBUG] Prediksi ID: {id_}, Confidence: {confidence:.2f}")

    nis = reverse_labels.get(id_)

    # Atur threshold confidence di bawah 70-90 tergantung kebutuhan
    if nis and confidence < 80:
        print(nis)  # Output hanya NIS jika dikenali
    else:
        print("Wajah tidak dikenali.")
except cv2.error as e:
    print(f"[ERROR] Gagal melakukan prediksi: {e}")
    sys.exit(1)
