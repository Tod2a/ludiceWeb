
import json
import csv
import os

from boardgamegeek import BGGClient
from googletrans import Translator

import requests
import asyncio

games_list = [
    "Monopoly",
    "Scrabble",
    "Risk",
    "Cluedo",
    "Les Colons de Catane",
    "Uno",
    "Dames",
    "Bataille Navale",
    "Pictionary",
    "7 Wonders",
    "7 Wonders Duel",
    "Aeon's End",
    "Agricola",
    "Alchemists",
    "Anachrony",
    "Architects of the West Kingdom",
    "Ark Nova",
    "Azul",
    "Barrage",
    "Battle Line",
    "Beyond the Sun",
    "Blood Rage",
    "Brass: Birmingham",
    "Brass: Lancashire",
    "Cacao",
    "Calico",
    "Camel Up",
    "Carcassonne",
    "Cartographers",
    "Cascadia",
    "Castles of Mad King Ludwig",
    "Catan",
    "Caverna: The Cave Farmers",
    "Champions of Midgard",
    "Clank!: A Deck-Building Adventure",
    "Clue",
    "Codenames",
    "Concordia",
    "Cosmic Encounter",
    "Coup",
    "Cryptid",
    "Dead of Winter: A Crossroads Game",
    "Decrypto",
    "Descent: Journeys in the Dark (Second Edition)",
    "Dice Forge",
    "Dixit",
    "Dominion",
    "Draftosaurus",
    "Dune: Imperium",
    "Eclipse: Second Dawn for the Galaxy",
    "Eldritch Horror",
    "Everdell",
    "Exploding Kittens",
    "Feast for Odin",
    "Five Tribes",
    "Flamme Rouge",
    "Flash Point: Fire Rescue",
    "Food Chain Magnate",
    "Forbidden Desert",
    "Forbidden Island",
    "Gaia Project",
    "Galaxy Trucker",
    "Gloomhaven",
    "Great Western Trail",
    "Hanabi",
    "Hive",
    "Inis",
    "Innovation",
    "Isle of Skye: From Chieftain to King",
    "Jaipur",
    "Jamaica",
    "Just One",
    "Kanban EV",
    "Keyflower",
    "King of Tokyo",
    "Kingdom Builder",
    "Kingdomino",
    "Kites",
    "Lords of Waterdeep",
    "Love Letter",
    "Mage Knight Board Game",
    "Mandala",
    "Marco Polo II: In the Service of the Khan",
    "Mariposas",
    "Marvel Champions: The Card Game",
    "Mechs vs. Minions",
    "Merchants & Marauders",
    "Mice and Mystics",
    "Monikers",
    "Monopoly",
    "Mysterium",
    "Nemesis",
    "Nidavellir",
    "Obsession",
    "On Mars",
    "Orléans",
    "Paleo",
    "Pandemic",
    "Pandemic Legacy: Season 1",
    "Parks",
    "Patchwork",
    "Photosynthesis",
    "Pillars of the Earth",
    "Pioneers",
    "Planet",
    "Point Salad",
    "Power Grid",
    "Project L",
    "Puerto Rico",
    "Quacks of Quedlinburg",
    "Qwirkle",
    "Race for the Galaxy",
    "Raiders of the North Sea",
    "Railroad Ink",
    "Res Arcana",
    "Rising Sun",
    "Robinson Crusoe: Adventures on the Cursed Island",
    "Roll for the Galaxy",
    "Root",
    "Santorini",
    "Scythe",
    "Sheriff of Nottingham",
    "Sherlock Holmes Consulting Detective",
    "Sleeping Gods",
    "Small World",
    "Smartphone Inc.",
    "Space Base",
    "Spirit Island",
    "Splendor",
    "Star Realms",
    "Star Wars: Imperial Assault",
    "Star Wars: Rebellion",
    "Stone Age",
    "Suburbia",
    "Sushi Go!",
    "Sushi Go Party!",
    "T.I.M.E Stories",
    "Taj Mahal",
    "Takenoko",
    "Tapestry",
    "Terraforming Mars",
    "Terra Mystica",
    "The Crew: The Quest for Planet Nine",
    "The Isle of Cats",
    "The Mind",
    "The Quest for El Dorado",
    "The Resistance",
    "The Voyages of Marco Polo",
    "Through the Ages: A New Story of Civilization",
    "Ticket to Ride",
    "Ticket to Ride: Europe",
    "Tigris & Euphrates",
    "Tiny Towns",
    "Trajan",
    "Trickerion: Legends of Illusion",
    "Twilight Imperium: Fourth Edition",
    "Twilight Struggle",
    "Underwater Cities",
    "Unlock!",
    "Viticulture Essential Edition",
    "Wavelength",
    "Welcome To...",
    "Wingspan",
    "Zombicide",
    "Zooloretto",
    "Arkham Horror: The Card Game",
    "Azul: Summer Pavilion",
    "Bohnanza",
    "Burgle Bros",
    "Carcassonne: Hunters and Gatherers",
    "Century: Spice Road",
    "Chronicles of Crime",
    "Citadels",
    "Colt Express",
    "Detective: A Modern Crime Board Game",
    "Dice Throne",
    "Dungeon Petz",
    "Everdell: Pearlbrook",
    "Flash Duel",
    "Gizmos",
    "Gloom",
    "Horrified",
    "Imperial Settlers",
    "Islebound",
    "Kingdomino: Age of Giants",
    "Lanterns: The Harvest Festival",
    "Legendary: A Marvel Deck Building Game",
    "Letter Jam",
    "Lords of Xidit",
    "Lost Cities",
    "Love Letter: Premium Edition",
    "Machi Koro",
    "Magic Maze",
    "Mandala Stones",
    "Men at Work",
    "MicroMacro: Crime City",
    "Mombasa",
    "Mysterium Park",
    "Nations",
    "Navegador",
    "New York Zoo",
    "No Thanks!",
    "One Night Ultimate Werewolf",
    "Orbis",
    "Outlive",
    "Paladins of the West Kingdom",
    "Pandemic: Iberia",
    "Pax Pamir: Second Edition",
    "Photosynthesis",
    "Pipeline",
    "Planet Unknown",
    "Port Royal",
    "Potion Explosion",
    "Project Gaia",
    "Pulsar 2849",
    "Quoridor",
    "Raiders of Scythia",
    "Rajas of the Ganges",
    "Red Cathedral",
    "Reef",
    "Rococo",
    "Roll Player",
    "Russian Railroads",
    "Saboteur",
    "San Juan",
    "Seasons",
    "Secret Hitler",
    "Set",
    "Shadows Over Camelot",
    "Shipwrights of the North Sea",
    "Skull",
    "Sleeping Queens",
    "Space Alert",
    "Sprawlopolis",
    "Spyfall",
    "Star Wars: Outer Rim",
    "Stockpile",
    "Stuffed Fables",
    "Super Motherload",
    "Survive: Escape from Atlantis!",
    "Targi",
    "Terraforming Mars: Ares Expedition",
    "The Bloody Inn",
    "The Estates",
    "The Gallerist",
    "The Grizzled",
    "The Networks",
    "The Prodigals Club",
    "The Red Cathedral",
    "The Taverns of Tiefenthal",
    "Thebes",
    "Thurn and Taxis",
    "Tiny Epic Galaxies",
    "Tokaido",
    "Trails of Tucana",
    "Troyes",
    "Tzolk'in: The Mayan Calendar",
    "Ubongo",
    "Unmatched: Battle of Legends",
    "Vinhos Deluxe Edition",
    "Viticulture",
    "Welcome To Your Perfect Home",
    "Wingspan: European Expansion",
    "Yamataï",
    "Yokohama",
    "Zendo",
    "Zoo Tycoon: The Board Game"
]



field_mapping = {
    "id": "id",
    "categories": "categories",
    "description": "description",
    "designers": "designers",
    "image": "img_path",
    "maxplayers": "max_players",
    "playingtime": "average_duration",
    "mechanics": "mechanics",
    "minage": "suggestedage",
    "minplayers": "min_players",
    "name": "name",
    "publishers": "publishers",
    "yearpublished": "published_at",
}

registry = {
    "mechanics": set(),
    "categories": set(),
    "designers": set(),
    "publishers": set(),
    "games": {},
}


def filter_bgg_data(game):
    """
    Extract only data we want from `field_mapping`
    """
    return {k: v for k, v in game.data().items() if k in field_mapping.keys()}


def build_registries(game_data):
    registry["games"][game_data["id"]] = game_data

    for field in ["mechanics", "categories", "designers", "publishers"]:
        for elem in game_data[field]:
            registry[field].add(elem)

def prepare_registry():
    # prepare entity ids
    for field in ["mechanics", "categories", "designers", "publishers"]:
        elem_ids = range(1, len(registry[field]) + 1)
        registry[field] = dict(zip(registry[field], elem_ids))


def download_img(url, filename):
    response = requests.get(url)
    full_path = f"images/games/{filename}.jpg"
    os.makedirs('images/games/', exist_ok=True)

    if response.status_code == 200:
        with open(full_path, 'wb') as file:
            file.write(response.content)
    return f"/storage/{full_path}"

def generate_storage():
    for id, game in registry["games"].items():
        game["image"] = download_img(game["image"], str(id))


async def generate_output():

    translator = Translator()

    for field in ["mechanics", "categories", "designers", "publishers"]:
        with open(f"{field}.csv", 'w', newline='') as csvfile:
            writer = csv.writer(csvfile, delimiter=';', quotechar='"', quoting=csv.QUOTE_MINIMAL)
            writer.writerow(["name", "id"])
            for name, id in registry[field].items():

                if  field in ("mechanics", "categories"):
                    translated = await translator.translate(name, src="en", dest="fr")
                    name = translated.text

                writer.writerow((name, id))


        with open(f"games_{field}.csv", 'w', newline='') as relcsvfile:
            writer = csv.writer(relcsvfile, delimiter=';', quotechar='"', quoting=csv.QUOTE_MINIMAL)
            writer.writerow(['game_id', f"{field}_id"])
            for game_id, game in registry["games"].items():
                for f_name in game[field]:
                    writer.writerow((game_id, registry[field][f_name]))

    with open(f"games.csv", 'w', newline='') as gamecsv:
        writer = csv.writer(gamecsv, delimiter=';', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        field_lst = ["id","description","image","maxplayers","playingtime","minage","minplayers","name","yearpublished"]
        writer.writerow([field_mapping[f] for f in field_lst])
        for id, game in registry["games"].items():
            writer.writerow([game[f] for f in field_lst])


async def translate_game():
    translator = Translator()
    for id, game in registry["games"].items():
        translated = await translator.translate(game["description"], src="en", dest="fr")
        game["description"] = translated.text

async def main():
    bgg = BGGClient()

    try:

        print("loading data...")

        file_path = 'data.json'

        if os.path.exists(file_path):
            with open(file_path, 'r') as f:
                registry = json.load(f)
        else:
            for game_name in games_list:
                try:
                    print(f"loading {game_name}...")
                    g = bgg.game(game_name)
                    data = filter_bgg_data(g)
                    build_registries(data)
                except Exception as exc:
                    print(f"Error: {game_name} - {exc}")
                    continue

        print("processing data...")
        await translate_game()
        prepare_registry()
        generate_storage()
        await generate_output()
    except Exception:
        with open(file_path, 'w') as f:
            json.dump(registry, f)

if __name__ == "__main__":
    asyncio.run(main())
