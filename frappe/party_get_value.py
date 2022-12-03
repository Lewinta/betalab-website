import json, click

from client import Client

@click.command()
@click.option('--party', help='Party your looking for leave blank for any')
@click.option('--hash', help='Specify the hash assigned to the party')
def run(hash, party="Paciente"):
	client = Client("http://app.laboratoriobetalab.com", "Usr", "P@ss")

	result = client.get_value(party, filters={
		"web_hash": hash,
	})

	print(result)

if __name__ == '__main__':
    run()