# MyDB
Bardzo prymitywna symulacja bazy danych napisania w PHP, wykorzystująca json

# Jak to działa
- Plik data.json przechowuje dane logowania wraz ze stworzonymi tabelami
- Klasa ,,rdzenia" bazy danych zawiera metody: connectDB(), closeDB(), getFromDB(), addIndexToTable()
- Sama klasa rdzenia potrzebuje jedynie zaimplementowania jej w skrypcie PHP za pomocą require lub inlude, aby zacząć jej używać
- W katalogu logs, istnieje również plik logs.txt rejestrujący wszystkie błędy w oprogramowaniu

#connectDB()
Ta metoda odpowiada za połączenie z bazą danych, przyjmuje 3 argumenty, kolejno: username, password, database_name ( znajdują się one w katalogu data w pliku data.json ).
Zwróci true jeśli uwierzytelniono, w przeciwnym wypadku false.

#closeDB()
Zamyka połączenie i uniemożliwia dalsze korzystanie na obecnej instancji, zwraca true jeśli się udało, w przeciwnym wypadku false

#getFromDB()
Metoda służy do pobrania pojedynczej wartości lub wielu wartości, przyjmuje następujące argumenty: tableName, values. Argument tableName odpowiada za nazwę tabeli w pliku data.json.
Natomiast values, służy do wskazania nazw indeksów.
Przykłady:
Pobranie pojedynczej wartości: $mydb->getFromDB('users', nickname: 'Janek')
Pobranie wielu wartości: $mydb->getFromDB('users', nickname: ['Janek', 'Teodor'])

#addIndexToTable()
Metoda służy do dodania nowych rekordów bazy danych, przyjmuje następujące wartości: tableName, newIndexes. Gdzie tableName jest nazwą tabeli do której chcemy dodać 
rekord/rekordy, a newIndexes jest tablicą.
Dodanie pojedynczego rekordu: $mydb->addIndexToTable('users', ['nickname' => 'test']
Dodanie wielu rekordów: $mydb->addIndexToTable('users', ['nickname' => 'test'], ['nickname' => 'drugi test'])
