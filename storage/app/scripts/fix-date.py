import csv

input_file = './games.csv'
output_file = './games_fixed.csv'

def fix_date(value):
    if value == '0' or not value or not value[0].isdigit():
        return '1900-01-01'
    if len(value) == 4 and value.isdigit():
        return f"{value}-01-01"
    return value

with open(input_file, newline='', encoding='utf-8') as infile, \
     open(output_file, 'w', newline='', encoding='utf-8') as outfile:

    reader = csv.DictReader(infile, delimiter=';')
    fieldnames = reader.fieldnames
    writer = csv.DictWriter(outfile, fieldnames=fieldnames, delimiter=';')
    writer.writeheader()

    for row in reader:
        row['published_at'] = fix_date(row['published_at'])
        writer.writerow(row)

print("File fixed and saved as:", output_file)
