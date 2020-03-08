
## Login and Registeration
- I used passport personal client token to authnticate users 
- there is two use that i created in the database dump 
- the first one is (email: admin@fleet.com password: test1234 ) and has the role of an admin
- the second one is (email: user@fleet.com password: test1234)
- you can register new user using the endpoint: /api/auth/register  it requires name , email, password (min: 8).
- you can login with any user using the endpoint: /api/auth/login  ir requires email, password



## Buses
admin can create new buses each bus has a 12 seat that will be created automatically once the bus has been created you can create a new bus using the 
endpoint: /api/buses/create and it requires plate number with the key of numbers it can is a string and it can be letters and numbers compined.
you can also edit an existing bus using endpoint: /api/buses/update and it requires id and numbers.
there are two buses in the database dump with the id of 1 and 2
## Stations
admin can create station using endpoint: /api/stations/create and it requires a name.
admin can also update a station using endpoint /api/stations/update which requires name and an id.
there are seven stations in the databasedump with the names of Cairo, AlFayyum, AlMinya, Asyut, Giza, Portsaid, Damietta

## Trips
admin can create new trips by using th endpoint: /api/trips/create which will take the input in the for of a JSON like this 
{
  "bus_id": 1,
  "route": [
    {"station_id": 7, "order": 1, "departure_date": "2020-03-10 1:26:32", "arrival_date": "2020-03-06 1:26:32"},
    {"station_id": 6, "order": 2, "departure_date": "2020-03-10 3:26:32", "arrival_date": "2020-03-06 3:26:32"},
    {"station_id": 2, "order": 3, "departure_date": "2020-03-10 6:26:32", "arrival_date": "2020-03-06 3:26:32"},
    {"station_id": 5, "order": 4, "departure_date": "2020-03-10 9:26:32", "arrival_date": "2020-03-06 3:26:32"}
  ]
}
the bus_id is the id of the bus doing the trip.
as for the route it is an array of Objects each object needs a station id which is the id of the station and an order which is the order in which the bus will cross over the station 1 being the station that the trip will start from a departure date which is dateTime and an arrival date which is date time.

a user can query the avaliable seats using the endpoint: api/tickets/departure/{departureStation}/arrival/{arrivalStation}
departureStation is the id of the station that the user is traveling from.
arrivalStation is the id of the station the user is traveling to.
the query will return an array of avaliable seats for the user to choose from.

## Tickets
a user can book a Ticket using the endpoint: api/tickets/book and it requires a trip_id , seat_id, departure_station which, arrival_station.
departure_station is the id of the station the user is traveling from.
arrival_station is the id of the station the user is traveling to.

booking a ticket requires the data to match the criteria meaning that if the api recicved a seat_id that is not avaliable or stations that is not withing a trip 
route it will not book a ticket.

