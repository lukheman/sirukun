# Note

- Tambahkan avatar pada admin, warga, dan pemda
-

# ERD

erDiagram
    ADMIN ||--o{ PENGAJUAN : "memverifikasi"
    PENGAJUAN ||--o| PENEMPATAN : "menghasilkan"
    UNIT_RUMAH ||--o| PENEMPATAN : "ditempati"
    WARGA ||--o| PENGAJUAN : "mengajukan"

    WARGA {
        int id_warga PK
        string nik
        string nkk
        string nama
        string alamat
        string telepon
        string tempat_lahir
        date tanggal_lahir
        string password
        string agama
    }
    PENGAJUAN {
        int id_pengajuan PK
        int id_warga FK
        string status_pengajuan
    }
    UNIT_RUMAH {
        int id_unit PK
        string blok
        string nomor
        string status_ketersediaan
    }
    PENEMPATAN {
        int id_penempatan PK
        int id_pengajuan FK
        int id_unit FK
        date tanggal_masuk
    }
    ADMIN {
        int id_admin PK
        string username
        string password
    }
