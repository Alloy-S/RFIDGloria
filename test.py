import requests

payload = {
    'uid': '0700ee0030798d56'
}
headers = {
    'Content-Type': 'application/json'
}
url = 'http://localhost/RFIDGloria/api/tapin.php'
try:
    response = requests.post(url, json=payload, headers=headers)

    # Memeriksa kode status respons
    print(response.content)
    if response.status_code == 200:
        print('Request successful!')
        print('Response:', response.json())  # Menampilkan respons JSON dari API
    else:
        print(f'Request failed with status code {response.status_code}')
        print('Response:', response.text)  # Menampilkan teks respons jika tidak 200 OK

except requests.exceptions.RequestException as e:
    print(f'An error occurred: {e}')