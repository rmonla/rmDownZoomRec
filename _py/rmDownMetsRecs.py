import requests

# Configuración de autenticación
API_KEY = 'tu_api_key'
API_SECRET = 'tu_api_secret'

# Obtener el token de acceso
def get_access_token():
    url = 'https://api.zoom.us/v2/users/me/token?type=token'
    response = requests.post(url, auth=(API_KEY, API_SECRET))
    data = response.json()
    return data['token']

# Obtener la lista de reuniones
def get_meetings():
    token = get_access_token()
    url = 'https://api.zoom.us/v2/users/me/meetings'
    headers = {
        'Authorization': f'Bearer {token}'
    }
    response = requests.get(url, headers=headers)
    data = response.json()
    return data['meetings']

# Obtener las grabaciones de una reunión
def get_meeting_recordings(meeting_id):
    token = get_access_token()
    url = f'https://api.zoom.us/v2/meetings/{meeting_id}/recordings'
    headers = {
        'Authorization': f'Bearer {token}'
    }
    response = requests.get(url, headers=headers)
    data = response.json()
    return data

# Ejemplo de uso: Obtener la lista de reuniones
meetings = get_meetings()

# Mostrar las grabaciones de todas las reuniones
for meeting in meetings:
    meeting_id = meeting['id']
    recordings = get_meeting_recordings(meeting_id)

    # Mostrar las grabaciones de la reunión actual
    for recording in recordings['meetings']:
        print('ID de reunión:', meeting_id)
        print('ID de grabación:', recording['uuid'])
        print('Fecha de grabación:', recording['recording_start'])
        print('URL de descarga:', recording['download_url'])
        print()
