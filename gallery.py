import os
import json

BASE_DIR = "/Users/darby/Desktop/media/website projects /portpholio"

IMAGE_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif")
VIDEO_EXTS = (".mp4", ".mov", ".webm")


def get_media(sub_path):

    if not os.path.exists(sub_path):
        return []

    files = sorted(os.listdir(sub_path))

    media = []

    for f in files:

        lower = f.lower()

        full = os.path.join(sub_path, f)

        if lower.endswith(IMAGE_EXTS):
            media.append(full)

        elif lower.endswith(VIDEO_EXTS):
            media.append(full)

    return media


def build_items(folder):

    full_root = os.path.join(BASE_DIR, folder)

    if not os.path.exists(full_root):
        print(f"Missing folder: {folder}")
        return []

    items = []

    for sub in sorted(os.listdir(full_root)):

        sub_path = os.path.join(full_root, sub)

        if not os.path.isdir(sub_path):
            continue

        media = get_media(sub_path)

        if len(media) == 0:
            print(f"⚠️ Empty or unreadable: {sub_path}")
            continue

        items.append({
            "title": sub.strip(),
            "thumb": media[0],
            "images": media
        })

    return items


galleries = {

    "2d": build_items("2D"),

    "3d": build_items("3D"),

    "4d": build_items("4D")
}


with open("galleries.js", "w") as f:
    f.write("const galleries = " + json.dumps(galleries, indent=2) + ";")

print("updateddddd")
