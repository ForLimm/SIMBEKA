import pypdf
import os

pdf_path = os.path.join("Dokumen-Kami", "[draft] Proyek Kolaborasi SI TI (1) (1).pdf")
output_path = os.path.join("scratch", "pdf_content.txt")

print(f"Reading {pdf_path}...")
reader = pypdf.PdfReader(pdf_path)
print(f"Total pages: {len(reader.pages)}")

full_text = []
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    full_text.append(f"--- PAGE {i+1} ---")
    full_text.append(text)

with open(output_path, "w", encoding="utf-8") as f:
    f.write("\n".join(full_text))

print(f"Text extracted successfully and saved to {output_path}")
