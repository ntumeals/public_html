# -*- coding: utf-8 -*-
from bs4 import BeautifulSoup
import sys, glob, json

f = open(sys.argv[1])
data = f.read()
soup = BeautifulSoup(data, "html.parser")

result = []

for i in soup.select("ul"):
    if not i.select(".title"):
        continue;
    info = []
    for j in i.select(".first"):
        inner = j.text.strip()
        if len(inner) > 0:
            info.append(inner)
    out = {"info": info, "data": []}
    for j in i.select("a"):
        out["data"].append([j.text, j.get("href")])
    result.append(out)

print(json.dumps(result, ensure_ascii=False))
