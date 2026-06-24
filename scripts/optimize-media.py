#!/usr/bin/env python3
"""Optimize CFI source media for web — generates gallery manifest."""

import json
import shutil
from pathlib import Path

from PIL import Image, ImageOps, ImageEnhance

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / "CFI"
OUT = ROOT / "assets" / "media"
THUMB_W = 480
FULL_W = 1400
JPEG_QUALITY = 82

COUNTRIES = [
    "zimbabwe", "namibia", "lesotho", "south-africa", "nigeria",
    "philippines", "niger", "botswana", "malawi",
]

BUILDING_HOUSE_DIR = SRC / "Building house"
BUILDING_HOUSE_COUNT = 8

CATEGORIES = [
    "outreach", "crusades", "food", "education",
    "healthcare", "widow", "shelter",
]

# All program filters shown in the gallery UI (includes dedicated imports).
GALLERY_FILTER_CATEGORIES = CATEGORIES + ["building-houses"]

COUNTRY_LABELS = {
    "zimbabwe": "Zimbabwe",
    "namibia": "Namibia",
    "lesotho": "Lesotho",
    "south-africa": "South Africa",
    "nigeria": "Nigeria",
    "philippines": "The Philippines",
    "niger": "Niger Republic",
    "botswana": "Botswana",
    "malawi": "Malawi",
}

# Curated hero & featured images (best outreach / team shots)
FEATURED = {
    "hero": [
        "IMG-20260603-WA0100.jpg",
        "IMG-20260603-WA0002.jpg",
        "IMG-20260603-WA0217.jpg",
        "IMG-20260603-WA0218.jpg",
    ],
    "mission": "IMG-20260603-WA0230.jpg",
    "story-featured": "IMG-20260603-WA0217.jpg",
    "founder": "IMG-20260603-WA0236.jpg",
    "stories": [
        "IMG-20260603-WA0242.jpg",
        "IMG-20260603-WA0238.jpg",
        "IMG-20260603-WA0068.jpg",
        "IMG-20260603-WA0115.jpg",
    ],
}


def image_score(path: Path) -> tuple:
    try:
        with Image.open(path) as im:
            w, h = im.size
        size = path.stat().st_size
        aspect = w / h if h else 0
        landscape_bonus = 1.2 if aspect >= 1.2 else 1.0
        return (w * h * landscape_bonus, w, h, size, path.name)
    except Exception:
        return (0, 0, 0, 0, path.name)


def save_founder_image(src: Path, dest: Path) -> None:
    """Crop, upscale, and sharpen founder photo — focus on prayer moment."""
    dest.parent.mkdir(parents=True, exist_ok=True)
    with Image.open(src) as im:
        im = ImageOps.exif_transpose(im)
        if im.mode not in ("RGB", "L"):
            im = im.convert("RGB")
        left, top, right, bottom = 45, 95, 875, 1310
        cropped = im.crop((left, top, right, bottom))
        cw, ch = cropped.size
        target_ratio = 3 / 4
        if cw / ch > target_ratio:
            new_w = int(ch * target_ratio)
            x0 = (cw - new_w) // 2
            cropped = cropped.crop((x0, 0, x0 + new_w, ch))
        else:
            new_h = int(cw / target_ratio)
            cropped = cropped.crop((0, 0, cw, min(ch, new_h)))
        out_w, out_h = 1500, 2000
        upscaled = cropped.resize((out_w, out_h), Image.Resampling.LANCZOS)
        upscaled = ImageEnhance.Sharpness(upscaled).enhance(1.35)
        upscaled = ImageEnhance.Contrast(upscaled).enhance(1.05)
        upscaled.save(dest, "JPEG", quality=88, optimize=True, progressive=True)


def save_variant(src: Path, dest: Path, max_width: int) -> None:
    dest.parent.mkdir(parents=True, exist_ok=True)
    with Image.open(src) as im:
        im = ImageOps.exif_transpose(im)
        if im.mode not in ("RGB", "L"):
            im = im.convert("RGB")
        w, h = im.size
        if w > max_width:
            nh = int(h * (max_width / w))
            im = im.resize((max_width, nh), Image.Resampling.LANCZOS)
        im.save(dest, "JPEG", quality=JPEG_QUALITY, optimize=True, progressive=True)


def slugify_filename(name: str) -> str:
    stem = Path(name).stem.lower()
    cleaned = "".join(ch if ch.isalnum() else "-" for ch in stem)
    while "--" in cleaned:
        cleaned = cleaned.replace("--", "-")
    return cleaned.strip("-") or "cfi-building"


def process_building_houses(gallery_items: list) -> list:
    """Add optimized images from CFI/Building house/ to the gallery."""
    if not BUILDING_HOUSE_DIR.exists():
        return gallery_items

    imgs = sorted(BUILDING_HOUSE_DIR.glob("*.jpeg")) + sorted(BUILDING_HOUSE_DIR.glob("*.jpg"))
    ranked = sorted((image_score(p) for p in imgs), reverse=True)
    selected = [name for score, _, _, _, name in ranked if score > 0][:BUILDING_HOUSE_COUNT]

    for i, name in enumerate(selected):
        src = BUILDING_HOUSE_DIR / name
        country = COUNTRIES[i % len(COUNTRIES)]
        slug = f"cfi-building-{slugify_filename(name)}"
        category = "building-houses"
        thumb = OUT / "gallery" / country / category / "thumb" / f"{slug}.jpg"
        full = OUT / "gallery" / country / category / "full" / f"{slug}.jpg"
        save_variant(src, thumb, THUMB_W)
        save_variant(src, full, FULL_W)
        gallery_items.append({
            "id": slug,
            "country": country,
            "countryLabel": COUNTRY_LABELS[country],
            "category": category,
            "type": "image",
            "thumb": f"assets/media/gallery/{country}/{category}/thumb/{slug}.jpg",
            "src": f"assets/media/gallery/{country}/{category}/full/{slug}.jpg",
            "alt": f"CharityFaith International — building houses for folks in {COUNTRY_LABELS[country]}",
            "source": name,
        })

    return gallery_items


def main() -> None:
    if not SRC.exists():
        raise SystemExit(f"Source folder not found: {SRC}")

    imgs = sorted(SRC.glob("*.jpg")) + sorted(SRC.glob("*.JPG"))
    ranked = sorted((image_score(p) for p in imgs), reverse=True)
    ranked_names = [n for _, _, _, _, n in ranked if _ > 0]

    featured_set = set(FEATURED["hero"] + [FEATURED["mission"], FEATURED["story-featured"],
                                          FEATURED["founder"]] + FEATURED["stories"])

    gallery_pool = [n for n in ranked_names if n not in featured_set][:72]

    # 8 images per country
    per_country = 8
    gallery_items = []

    for i, name in enumerate(gallery_pool):
        country = COUNTRIES[i // per_country % len(COUNTRIES)]
        category = CATEGORIES[i % len(CATEGORIES)]
        src = SRC / name
        slug = Path(name).stem.lower().replace("img-", "cfi-")
        thumb = OUT / "gallery" / country / category / "thumb" / f"{slug}.jpg"
        full = OUT / "gallery" / country / category / "full" / f"{slug}.jpg"
        save_variant(src, thumb, THUMB_W)
        save_variant(src, full, FULL_W)
        gallery_items.append({
            "id": slug,
            "country": country,
            "countryLabel": COUNTRY_LABELS[country],
            "category": category,
            "type": "image",
            "thumb": f"assets/media/gallery/{country}/{category}/thumb/{slug}.jpg",
            "src": f"assets/media/gallery/{country}/{category}/full/{slug}.jpg",
            "alt": f"CharityFaith International {COUNTRY_LABELS[country]} — {category.replace('-', ' ')}",
            "source": name,
        })

    gallery_items = process_building_houses(gallery_items)

    # Featured / hero images
    featured_out = {}
    for key, files in [("hero", FEATURED["hero"])]:
        featured_out[key] = []
        for idx, name in enumerate(files):
            src = SRC / name
            if not src.exists():
                continue
            dest = OUT / "featured" / f"hero-{idx + 1}.jpg"
            save_variant(src, dest, 1920)
            featured_out[key].append(f"assets/media/featured/hero-{idx + 1}.jpg")

    for key in ("mission", "story-featured"):
        name = FEATURED[key]
        src = SRC / name
        if src.exists():
            dest = OUT / "featured" / f"{key}.jpg"
            save_variant(src, dest, FULL_W)
            featured_out[key] = f"assets/media/featured/{key}.jpg"

    founder_src = SRC / FEATURED["founder"]
    if founder_src.exists():
        founder_dest = OUT / "featured" / "founder.jpg"
        save_founder_image(founder_src, founder_dest)
        featured_out["founder"] = "assets/media/featured/founder.jpg"

    featured_out["stories"] = []
    for idx, name in enumerate(FEATURED["stories"]):
        src = SRC / name
        if not src.exists():
            continue
        dest = OUT / "featured" / f"story-{idx + 1}.jpg"
        save_variant(src, dest, 800)
        featured_out["stories"].append(f"assets/media/featured/story-{idx + 1}.jpg")

    # Valid videos: 1–18 MB (skip corrupt tiny files)
    video_items = []
    vids = sorted(SRC.glob("*.mp4"), key=lambda p: p.stat().st_size)
    valid_vids = [p for p in vids if 1_000_000 <= p.stat().st_size <= 18_000_000]
    vid_out = OUT / "videos"
    vid_out.mkdir(parents=True, exist_ok=True)

    for i, src in enumerate(valid_vids[:9]):
        country = COUNTRIES[i % len(COUNTRIES)]
        category = "crusades" if i % 2 == 0 else "outreach"
        slug = f"cfi-video-{i + 1}"
        dest = vid_out / f"{slug}.mp4"
        shutil.copy2(src, dest)
        thumb_ref = gallery_items[i % len(gallery_items)]["thumb"] if gallery_items else ""
        video_items.append({
            "id": slug,
            "country": country,
            "countryLabel": COUNTRY_LABELS[country],
            "category": category,
            "type": "video",
            "thumb": thumb_ref,
            "src": f"assets/media/videos/{slug}.mp4",
            "alt": f"CharityFaith International field video — {COUNTRY_LABELS[country]}",
            "source": src.name,
        })

    manifest = {
        "countries": [{"id": c, "label": COUNTRY_LABELS[c]} for c in COUNTRIES],
        "categories": GALLERY_FILTER_CATEGORIES,
        "featured": featured_out,
        "gallery": gallery_items + video_items,
    }

    data_dir = ROOT / "assets" / "data"
    data_dir.mkdir(parents=True, exist_ok=True)
    (data_dir / "gallery.json").write_text(json.dumps(manifest, indent=2), encoding="utf-8")

    building_count = sum(1 for item in gallery_items if item.get("category") == "building-houses")
    print(f"Gallery images: {len(gallery_items)} ({building_count} building houses)")
    print(f"Videos: {len(video_items)}")
    print(f"Featured hero slides: {len(featured_out.get('hero', []))}")
    print(f"Manifest: {data_dir / 'gallery.json'}")


if __name__ == "__main__":
    main()
