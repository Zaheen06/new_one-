from PIL import Image
import numpy as np

# Load the image
img = Image.open('logo1.jpg')

# Convert to RGBA if not already
if img.mode != 'RGBA':
    img = img.convert('RGBA')

# Get the image data as a numpy array
data = np.array(img)

# Define the white color range (adjust threshold as needed)
white_threshold = 200  # Pixels with RGB values above this are considered white

# Create a mask for white pixels
mask = (data[:, :, 0] > white_threshold) & (data[:, :, 1] > white_threshold) & (data[:, :, 2] > white_threshold)

# Set alpha channel to 0 for white pixels
data[mask, 3] = 0

# Create new image with transparency
transparent_img = Image.fromarray(data, 'RGBA')

# Save as PNG
transparent_img.save('logo1.png')

print("Transparent logo saved as logo1.png")
