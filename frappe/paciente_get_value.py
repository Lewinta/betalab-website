import json, click

from client import Client

@click.command()
@click.option('--hash', help='Specify the hash assigned to the party')
@click.option('--party', help='Party your looking for leave blank for any', 
	type=click.Choice(['Paciente', 'Medico', 'Empresa']))
def run(hash, party="Paciente"):
	client = Client("http://app.laboratoriobetalab.com", "Administrator", "P@ssword2017")

	result = client.get_value(party, filters={
		"web_hash": hash,
	})

	print(result)

if __name__ == '__main__':
    run()