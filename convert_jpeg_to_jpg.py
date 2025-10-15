from PIL import Image
import os
import glob

# Find all JPEG files in the current directory
jpeg_files = glob.glob('*.JPEG')

for jpeg_file in jpeg_files:
    try:
        # Open the JPEG file
        img = Image.open(jpeg_file)
        
        # Convert to RGB if necessary
        if img.mode != 'RGB':
            img = img.convert('RGB')
        
        # Generate output filename with .jpg extension
        jpg_filename = os.path.splitext(jpeg_file)[0] + '.jpg'
        
        # Save as JPG
        img.save(jpg_filename, 'JPEG', quality=95)
        
        print(f"Converted {jpeg_file} to {jpg_filename}")
        
    except Exception as e:
        print(f"Error converting {jpeg_file}: {e}")

print("JPEG to JPG conversion completed.")
