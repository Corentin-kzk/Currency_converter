# MoneyConverter API Documentation

Welcome to the MoneyConverter API documentation! This API allows you to convert amounts between different currencies. Below are the available routes along with the details for each route.

## API Name: MoneyConverter

## Base URL: `https://localhost:8000/api`

---

### Route: `/api/ping`

This route is used to check if the API is online and functioning correctly.

- Method: GET
- Arguments: None
- Successful Response: 200 OK with the text "The Laravel server is online and functioning correctly."

Example Request:
```
GET https://localhost:8000/api/ping
```

Example Response:
```
"The Laravel server is online and functioning correctly."
```

---

### Route: `/api/count`

This route is used to get the exchange rate between two specified currencies.

- Method: GET
- Arguments:
  - 'from' (required): The code of the currency you want to convert from (among 'EUR', 'BTC', and 'USD').
  - 'to' (required): The code of the currency you want to convert to (among 'EUR', 'BTC', and 'USD').
- Successful Response: 200 OK with the exchange rate between the two specified currencies.

Example Request:
```
GET https://localhost:8000/api/count?from=EUR&to=USD
```

Example Response:
```
10
```

---

### Route: `/api/pairs`

This route returns all available currency pairs along with their respective exchange rates.

- Method: GET
- Arguments: None
- Successful Response: 200 OK with a list of available currency pairs and their exchange rates.

Example Request:
```
GET https://localhost:8000/api/pairs
```

Example Response:
```
[
  {"id": 1,"from": "EUR", "to": "USD", "rate": 1.18},
  {"id": 2,"from": "USD", "to": "BTC", "rate": 0.000021},
  {"id": 3,"from": "EUR", "to": "BTC", "rate": 0.000018}
]
```

---

### Route: `/api/convert`

This route is used to convert an amount from one currency to another.

- Method: GET
- Arguments:
  - 'from' (required): The code of the currency you want to convert from (among 'EUR', 'BTC', and 'USD').
  - 'to' (required): The code of the currency you want to convert to (among 'EUR', 'BTC', and 'USD').
  - 'amount' (required): The amount you want to convert.
- Successful Response: 200 OK with the converted amount in the target currency.

Example Request:
```
GET https://localhost:8000/api/convert?from=USD&to=EUR&amount=100
```

Example Response:
```
84.75
```

---

That concludes the documentation for the MoneyConverter API. You can now use these routes to perform currency conversions. Remember to handle errors and validate user inputs for an optimal user experience. If you have any issues or questions, feel free to contact us. Happy coding!

---

Please note that the base URL (`https://localhost:8000/api`) should be replaced with the actual domain where your API is hosted. Also, you can add more details or sections to the Markdown file as needed.