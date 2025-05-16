
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
    "Les Aventuriers du Rail",
    "Les Loups-Garous de Thiercelieux",
    "Dixit",
    "Codenames",
    "7 Wonders Duel",
    "Mysterium",
    "Kingdomino",
    "Carcassonne",
    "Jenga",
    "Burger Quiz",
    "Skyjo",
    "Trio",
    "Kluster",
    "Crack List",
    "Perudo",
    "Here to Slay",
    "Draftosaurus",
    "Celestia",
    "Western Legends",
    "Shadow Hunters",
    "Bingo",
    "Gloomhaven",
    "Pandemic Legacy: Season 1",
    "Brass: Birmingham",
    "Terraforming Mars",
    "Twilight Imperium: Fourth Edition",
    "Twilight Struggle",
    "Star Wars: Rebellion",
    "Gaia Project",
    "Through the Ages: A New Story of Civilization",
    "Spirit Island",
    "Great Western Trail",
    "Scythe",
    "Ark Nova",
    "Root",
    "Wingspan",
    "Everdell",
    "Concordia",
    "The Castles of Burgundy",
    "Viticulture Essential Edition",
    "Lost Ruins of Arnak",
    "Clank!: A Deck-Building Adventure",
    "Azul",
    "Cascadia",
    "Ticket to Ride: Europe",
    "Dominion",
    "Dune: Imperium",
    "Brass: Lancashire",
    "Mansions of Madness: Second Edition",
    "Blood Rage",
    "Sleeping Gods",
    "Arkham Horror: The Card Game",
    "The Quacks of Quedlinburg",
    "Nemesis",
    "Pax Pamir: Second Edition",
    "Patchwork",
    "Splendor",
    "Agricola",
    "Barrage",
    "On Mars",
    "Orléans",
    "Paladins of the West Kingdom",
    "Raiders of the North Sea",
    "The Crew: The Quest for Planet Nine",
    "Marvel Champions: The Card Game",
    "The Isle of Cats",
    "Tzolk'in: The Mayan Calendar",
    "A Feast for Odin",
    "Pandemic",
    "Clank! Legacy: Acquisitions Incorporated",
    "Teotihuacan: City of Gods",
    "Trickerion: Legends of Illusion",
    "Anachrony",
    "Praga Caput Regni",
    "Underwater Cities",
    "The Voyages of Marco Polo",
    "Calico",
    "Project L",
    "Terraforming Mars: Ares Expedition",
    "Quacks & Co.: Quedlinburg Dash",
    "The Mind",
    "Cartographers: A Roll Player Tale",
    "MicroMacro: Crime City",
    "King of Tokyo",
    "Decrypto",
    "Just One",
    "Obsession",
    "Res Arcana",
    "Heat: Pedal to the Metal",
    "The Crew: Mission Deep Sea",
    "Unlock!",
    "Exit: The Game",
    "Sagrada",
    "Santorini",
    "Bohnanza",
    "Love Letter",
    "Hanabi",
    "Camel Up",
    "Qwirkle",
    "Azul: Summer Pavilion",
    "Wavelength",
    "Everdell: Pearlbrook",
    "Root: The Riverfolk Expansion",
    "Spirit Island: Jagged Earth",
    "Terraforming Mars: Hellas & Elysium",
    "7 Wonders",
    "Carcassonne: Inns & Cathedrals",
    "Ticket to Ride: Nordic Countries",
    "Dominion: Intrigue",
    "Pandemic: On the Brink",
    "Codenames: Pictures",
    "Splendor: Cities of Splendor",
    "Agricola: All Creatures Big and Small",
    "Patchwork Doodle",
    "Kingdomino: Age of Giants",
    "Scythe: The Wind Gambit",
    "Blood Rage: Gods of Asgard",
    "Clank!: Sunken Treasures",
    "The Quacks of Quedlinburg: The Herb Witches",
    "Nemesis: Lockdown",
    "Pax Pamir: First Edition",
    "Lost Ruins of Arnak: Expedition Leaders",
    "Calico: Collector's Edition",
    "On Mars: Deluxe Edition",
    "Orléans: Invasion",
    "Paladins of the West Kingdom: Architects",
    "Raiders of the North Sea: Hall of Heroes",
    "Marvel Champions: The Sidekick",
    "The Isle of Cats: Late Arrivals",
    "Tzolk'in: The Mayan Calendar - Tribes & Prophecies",
    "A Feast for Odin: The Norwegians",
    "Pandemic Legacy: Season 2",
    "Clank! Legacy: Acquisitions Incorporated - The Adventure",
    "Teotihuacan: City of Gods - The Dice Game",
    "Trickerion: Legends of Illusion - The Dark Arts",
    "Anachrony: Fractures of Time",
    "Praga Caput Regni: The Golden Age",
    "Underwater Cities: New Discoveries",
    "The Voyages of Marco Polo: The Silk Road",
    "Project L: Master Set",
    "Terraforming Mars: Venus Next",
    "The Mind: Extreme",
    "Cartographers: A Roll Player Tale - Heroes",
    "MicroMacro: Crime City - Full House",
    "King of Tokyo: Power Up!",
    "Decrypto: The Party Game",
    "Just One: Party",
    "Obsession: The Victorian Era",
    "Res Arcana: Lux",
    "Heat: Pedal to the Metal - Expansion",
    "Dixit: Odyssey",
    "Unlock!: Exotic Adventures",
    "Exit: The Game - The Abandoned Cabin",
    "Sagrada: Passion",
    "Santorini: Golden Fleece",
    "Bohnanza: The Duel",
    "Love Letter: Premium Edition",
    "Hanabi: Deluxe",
    "Camel Up: Supercup",
    "Qwirkle: Travel Edition",
    "Les Loups-Garous de Thiercelieux: Nouvelle Edition",
    "Mysterium: Hidden Signs",
    "Jenga: Classic",
    "Burger Quiz: The Board Game",
    "Trio: The Card Game",
    "Kluster: The Dice Game",
    "Crack List: The Expansion",
    "Perudo: The Classic",
    "Here to Slay: The Expansion",
    "Draftosaurus: The Expansion",
    "Celestia: The Lost Expedition",
    "Western Legends: The Gold Rush",
    "Shadow Hunters: The Dark",
    "Bingo: The Classic Game",
    "Gloomhaven: Jaws of the Lion",
    "Pandemic Legacy: Season 0",
    "Brass: Lancashire - The Expansion",
    "Terraforming Mars: Colonies",
    "Twilight Imperium: Prophecy of Kings",
    "Twilight Struggle: Deluxe Edition",
    "Star Wars: Rebellion - Rise of the Empire",
    "Gaia Project: The Expansion",
    "Through the Ages: A New Story of Civilization - Digital Edition",
    "Spirit Island: Branch & Claw",
    "Great Western Trail: Rails to the North",
    "Scythe: Invaders from Afar",
    "Ark Nova: Deluxe Edition",
    "Root: The Underworld Expansion",
    "Wingspan: European Expansion",
    "Everdell: Newleaf",
    "Concordia: Salsa",
    "The Castles of Burgundy: The Dice Game",
    "7 Wonders Duel: Pantheon",
    "Viticulture Essential Edition: Tuscany",
    "Lost Ruins of Arnak: The Lost Expedition",
    "Clank!: The Mummy's Curse",
    "Azul: Stained Glass of Sintra",
    "Cascadia: Collector's Edition",
    "Carcassonne: Winter Edition",
    "Ticket to Ride: United Kingdom",
    "Dominion: Seaside",
    "Dune: Imperium - Rise of Ix",
    "Mansions of Madness: Second Edition - The Labyrinth",
    "Blood Rage: The Expansion",
    "Codenames: Duet",
    "Sleeping Gods: Daughters of the North",
    "Arkham Horror: The Card Game - The Dunwich Legacy",
    "The Quacks of Quedlinburg: The Alchemists",
    "Nemesis: The Expansion",
    "Pax Pamir: Second Edition - The Expansion",
    "Patchwork: The Card Game",
    "Splendor: Marvel",
    "Agricola: Family Edition",
    "Barrage: The Expansion",
    "On Mars: The Board Game",
    "Orléans: Invasion - The Expansion",
    "Paladins of the West Kingdom: Architects - The Expansion",
    "Raiders of the North Sea: Hall of Heroes - The Expansion",
    "Marvel Champions: The Card Game - The Expansion",
    "The Isle of Cats: Late Arrivals - The Expansion",
    "A Feast for Odin: The Norwegians - The Expansion",
    "Pandemic Legacy: Season 2 - The Expansion",
    "Clank! Legacy: Acquisitions Incorporated - The Adventure - The Expansion",
    "Teotihuacan: City of Gods - The Dice Game - The Expansion",
    "Trickerion: Legends of Illusion - The Dark Arts - The Expansion",
    "Anachrony: Fractures of Time - The Expansion",
    "Praga Caput Regni: The Golden Age - The Expansion",
    "Underwater Cities: New Discoveries - The Expansion",
    "The Voyages of Marco Polo: The Silk Road - The Expansion",
    "Project L: Master Set - The Expansion",
    "Terraforming Mars: Venus Next - The Expansion",
    "The Mind: Extreme - The Expansion",
    "Cartographers: A Roll Player Tale - Heroes - The Expansion",
    "MicroMacro: Crime City - Full House - The Expansion",
    "King of Tokyo: Power Up! - The Expansion",
    "Decrypto: The Party Game - The Expansion",
    "Just One: Party - The Expansion",
    "Obsession: The Victorian Era - The Expansion",
    "Res Arcana: Lux - The Expansion",
    "Heat: Pedal to the Metal - Expansion - The Expansion",
    "Dixit: Odyssey - The Expansion",
    "Unlock!: Exotic Adventures - The Expansion",
    "Exit: The Game - The Abandoned Cabin - The Expansion",
    "Sagrada: Passion - The Expansion",
    "Santorini: Golden Fleece - The Expansion",
    "Bohnanza: The Duel - The Expansion",
    "Love Letter: Premium Edition - The Expansion",
    "Hanabi: Deluxe - The Expansion",
    "Camel Up: Supercup - The Expansion",
    "Qwirkle: Travel Edition - The Expansion",
    "Les Loups-Garous de Thiercelieux: Nouvelle Edition - The Expansion",
    "Mysterium: Hidden Signs - The Expansion",
    "Jenga: Classic - The Expansion",
    "Burger Quiz: The Board Game - The Expansion",
    "Trio: The Card Game - The Expansion",
    "Kluster: The Dice Game - The Expansion",
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
