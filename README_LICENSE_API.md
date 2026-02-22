# License API v1

Base path: `/v1/licenses`

Header global:
- `X-Application-Code` (required)
- `X-Application-Token` (optional)

Bearer token required:
- `GET /status`
- `POST /renew`
- `POST /devices/deactivate`
- `GET /devices`

Error format:
```json
{ "code": "ERROR_CODE", "message": "Descriptive message" }
```

Endpoints:
1. `POST /v1/licenses/activate`
2. `POST /v1/licenses/trial`
3. `GET /v1/licenses/status`
4. `POST /v1/licenses/renew`
5. `POST /v1/licenses/devices/deactivate`
6. `GET /v1/licenses/devices`

Catatan:
- Contract field request/response tidak boleh diubah pada `/v1`.
- Perubahan incompatible harus melalui versi baru, misal `/v2/licenses`.
