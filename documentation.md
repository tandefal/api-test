## General info

Dev url: http://localhost:8000

All the params in POST request must be transferred as `aplication/json`.

## Endpoints

- `GET /user/all` - user list
    - Request: (no params)
    - Response:
      ```json
      {
        "response": [
          {
            "id": 1,
            "name": "test",
            "created_at": "2024-04-26 17:56:20",
            "updated_at": "2024-04-26 17:56:20"
          }
        ]
      }
      ```
- `POST /user/create` - create user
    - Request: 
      - (required, string) `name`
    - Response:
      ```json
      {
        "success": true
      }
      ```
- `POST /user/remove` - remove user
  - Request:
    - (required, int) `id`
  - Response:
    ```json
    {
      "success": true
    }
    ```