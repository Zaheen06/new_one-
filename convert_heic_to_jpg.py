from PIL import Image
import pillow_heif
import os
import glob

# Register HEIF opener
pillow_heif.register_heif_opener()

# Find all HEIC files in the current directory
heic_files = glob.glob('*.HEIC')

for heic_file in heic_files:
    try:
        # Open the HEIC file
        img = Image.open(heic_file)

        # Convert to RGB if necessary (HEIC might be RGBA or other)
        if img.mode != 'RGB':
            img = img.convert('RGB')

        # Generate output filename
        jpg_filename = os.path.splitext(heic_file)[0] + '.jpg'

        # Save as JPG
        img.save(jpg_filename, 'JPEG', quality=95)

        print(f"Converted {heic_file} to {jpg_filename}")

    except Exception as e:
        print(f"Error converting {heic_file}: {e}")

print("HEIC to JPG conversion completed.")
