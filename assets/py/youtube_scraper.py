import requests
from bs4 import BeautifulSoup
import sys


def youtube_scraper(query):
    url_list = []
    scrape_url = "https://www.youtube.com"
    search_url = "/results?search_query="
    search_hardcode = query

    url = scrape_url + search_url + search_hardcode

    sb_get = requests.get(url)

    soupeddata = BeautifulSoup(sb_get.content, "html.parser")

    yt_links = soupeddata.find_all("a", class_="yt-uix-tile-link")

    for x in yt_links:
        yt_href = x.get("href")

        yt_final = scrape_url + yt_href

        url_list.append(yt_final)

    return url_list[1]




def main():
    # query = "shape-of-you"
    query = sys.argv[1]
    return youtube_scraper(query)


if __name__ == "__main__":
    print(main())
