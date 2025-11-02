erDiagram
    USERS ||--o{ ORDERS : "places"
    USERS ||--o{ CART : "has"
    USERS ||--o{ PAYMENTS : "makes"
    
    CATEGORIES ||--o{ PRODUCTS : "contains"
    
    PRODUCTS ||--o{ ORDER_ITEMS : "included_in"
    PRODUCTS ||--o{ CART : "added_to"
    
    ORDERS ||--o{ ORDER_ITEMS : "contains"
    ORDERS ||--o{ PAYMENTS : "has"

    USERS {
        int id PK
        string name
        string email UK
        string password
        enum role "user, admin"
        timestamp created_at
        timestamp updated_at
    }
    
    CATEGORIES {
        int id PK
        string name
        text description
        timestamp created_at
    }

    PRODUCTS {
        int id PK
        int category_id FK
        string name
        text description
        decimal price
        string image
        int stock
        timestamp created_at
        timestamp updated_at
    }

    CART {
        int id PK
        int user_id FK
        int product_id FK
        int quantity
        timestamp added_at
    }

    ORDERS {
        int id PK
        int user_id FK
        decimal total
        enum status "pending, processing, paid, shipped, delivered, cancelled"
        text shipping_address
        string payment_method
        timestamp created_at
        timestamp updated_at
    }

    ORDER_ITEMS {
        int id PK
        int order_id FK
        int product_id FK
        int quantity
        decimal price_at_purchase
        timestamp created_at
    }

    PAYMENTS {
        int id PK
        int order_id FK
        decimal amount
        enum method "credit_card, paypal, cash_on_delivery"
        enum status "pending, completed, failed"
        string transaction_id
        timestamp created_at
    }