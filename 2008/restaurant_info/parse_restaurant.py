# -*- coding: utf-8 -*-
from bs4 import BeautifulSoup
import sys, glob, json

grp = {}

li_keys = {
  "本校營業地點位置": "location",
  "餐飲業者名稱": "name",
  "公司名稱": "company",
  "營業時間及休息日": "open",
  "營業時間": "open",
  "聯絡電話": "tel",
  "營業項目、型態": "type",
  "業者簡介": "description",
  "網址": "website"
}

result = []

for fn in glob.glob("*.html"):
    f = open(fn)
    data = f.read()
    soup = BeautifulSoup(data, "html.parser")

    shop_id = fn.split(".")[0]
    out = {"id": shop_id}
    # 店名
    out['name'] = soup.select(".title")[0].text

    # 群組
    neigh = soup.select("a")
    out['group'] = {}
    out['group']['type'] = 0
    if len(neigh) > 0:
        out['group']['type'] = 2
        gp = shop_id.split("-")
        gid = gp[0] + gp[1]
        out['group']['id'] = gid
        # create group if not exist
        if not grp.get(gid):
            grp[gid] = {}
        if len(gp) == 2:
            # portal
            out['group']['type'] = 1
            for i in neigh:
                grp[gid][i.text] = i.get("href")

    # 店屬性
    out['data'] = {}
    for i in soup.select("ul.list")[0].select('li'):
        if len(i.select("span")) > 0:
            out['data'][li_keys[i.select("span")[0].text.replace(" ", "")]] = i.text.replace(i.select("span")[0].text, "").replace("\xa0 ", "").replace("\xa0", "").strip()
    out['data']['img'] = []
    for i in soup.select("img"):
        out['data']['img'].append(i.get("src"))
    print(out)
    result.append(out)

# print(json.dumps(result))
