import os
import json

def folder_to_dict(path):
    structure = {
        "name": os.path.basename(path),
        "type": "folder",
        "children": []
    }

    try:
        for item in os.listdir(path):
            item_path = os.path.join(path, item)

            if os.path.isdir(item_path):
                structure["children"].append(folder_to_dict(item_path))
            else:
                structure["children"].append({
                    "name": item,
                    "type": "file"
                })
    except PermissionError:
        pass

    return structure


root_path = r"C:\xampp\htdocs\AgroConnect"

output_path = os.path.join(root_path, "folder_structure.json")

folder_structure = folder_to_dict(root_path)

with open(output_path, "w", encoding="utf-8") as f:
    json.dump(folder_structure, f, indent=4)

print("✅ JSON saved at:", output_path)
