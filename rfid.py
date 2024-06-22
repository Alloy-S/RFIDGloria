import serial
import requests

def hex_to_binary(hex_string):
    scale = 16  # base hexadecimal
    num_of_bits = len(hex_string) * 4
    return bin(int(hex_string, scale))[2:].zfill(num_of_bits)

def parse_iso18000_6b(hex_data):
    # Assume hex_data is a string of concatenated hex values.
    # Split the data into 16-character segments (since each tag is 16 characters long).
    tags = [hex_data[i:i+16] for i in range(0, len(hex_data), 16)]
    
    parsed_data = []
    for tag in tags:
        # Convert each tag to binary for better interpretation
        binary_data = hex_to_binary(tag)
        parsed_data.append(tag)
    
    return list(set(parsed_data))
# Tentukan port serial dan pengaturan yang sesuai
port = 'COM4'  # Ganti dengan port serial yang sesuai
baudrate = 9600  # Ganti dengan baud rate yang sesuai dengan perangkat Anda

try:
    # Buka port serial
    ser = serial.Serial(port, baudrate, timeout=1)

    print(f"Connected to {port} at {baudrate} baud.")

    # Baca data dari perangkat serial
    while True:
        # if ser.in_waiting > 0:
        data = ser.readline().hex()
        if data:
            parsed_tags = parse_iso18000_6b(data)
            print(f"Read data: {parsed_tags}")
            for item in parsed_tags :
                payload = {
                    'uid': item
                }
                url = 'http://localhost/RFIDGloria/api/tapin.php'
                try:
                    response = requests.post(url, json=payload)

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

except serial.SerialException as e:
    print(f"Error: {e}")
except KeyboardInterrupt as e:
    if ser.is_open:
        ser.close()
        print(f"Disconnected from {port}")

finally:
    # Tutup port serial saat selesai
    if ser.is_open:
        ser.close()
        print(f"Disconnected from {port}")

