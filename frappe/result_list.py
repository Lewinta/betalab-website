import json, click

from client import Client

@click.command()
@click.option('--patient', help='Patient your looking for leave blank for any')
@click.option('--from_date', help='Start Date')
@click.option('--to_date', help='End Date')
@click.option('--doctor', help='Specify the Doctor who is working with the patient')
def run(patient="%",  doctor="%", from_date=None, to_date=None):
	client = Client("http://app.laboratoriobetalab.com", "Usr", "pass")

	result_list = client.get_list("Resultado", filters=[
			["paciente", "Like", "%{patient}%".format(patient=patient or "%")],
			["fecha", ">=", from_date or "1900-01-01"],
			["fecha", "<=", to_date or "3000-01-01"],
			["medico", "Like", "%{doctor}%".format(doctor=doctor  or "%")]
		], fieldname="name, fecha, paciente, docstatus")

	print(result_list)

if __name__ == '__main__':
    run()