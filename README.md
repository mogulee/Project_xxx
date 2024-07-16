# API 描述

## Order API

此 API 為新增/更新訂單功能。當接收到訂單資訊的請求時，會檢查其規則，若符合轉換條件，便新增/更新一筆資料到資料庫

note : 暫不考慮資料重複性

### SOLID 原則和模組化

此 API 遵循 SOLID 原則：

- **單一職責**：`OrderController` 只負責處理 HTTP 請求和響應，而 `OrderService` 負責處理訂單的資料轉換邏輯
- **開放封閉原則**：調整 `OrderService` 來變更訂單資訊轉換的邏輯，並不會影響 `OrderController` 。
- **里氏替換原則**：若未來有新的訂單服務，只要新的服務實現與 `OrderService` 一樣的接口，可以確保在使用繼承和多型時仍然能夠正常運作。
- **介面隔離原則**：`OrderController`只取他需要的功能，不用管`OrderService`是否還有其他功能。
- **依賴反轉原則**：`OrderController` 只需要知道 `OrderService`，而不需要知道他具體如何實現。

此 API 也實現了模組化，將不同的功能劃分到不同的類和方法中，未來若有其他的功能便可更有效的維護。


## 資料庫測驗

### 題目一
#### 請寫出一條查詢語句 (SQL),列出在 2023 年 5 月下訂的訂單,使用台幣付款且5月總金額最多的前 10 筆的旅宿 ID (bnb_id), 旅宿名稱 (bnb_name), 5 月總金額 (may_amount)
    Ans : 
        `SELECT
            o.bnb_id,
            b.bnb_name,
            SUM(o.amount) AS may_amount
        FROM         orders o
        JOIN         bnbs b ON o.bnb_id = b.id
        WHERE  o.currency = 'TWD'
        AND o.check_in_date BETWEEN '2023-05-01' AND '2023-05-31'
        GROUP BY o.bnb_id, b.bnb_name
        ORDER BY may_amount DESC
        LIMIT 10;`
### 題目二
#### 在題目一的執行下,我們發現 SQL 執行速度很慢,您會怎麼去優化?請闡述您怎麼判斷與優化的方式
    ANS:
        因為上述做法是資料一筆一筆比較時間，故筆數越多的話，執行上就會越久，故透過函數化去尋找特定年月的資料執行上會更好。
        優化如下 => 
            SELECT
                o.bnb_id,
                b.bnb_name,
                SUM(o.amount) AS may_amount
            FROM orders o
            JOIN bnbs b ON o.bnb_id = b.id
            WHERE o.currency = 'TWD' AND MONTH(o.check_in_date) = 5
            AND YEAR(o.check_in_date) = 2023
            GROUP BY o.bnb_id, b.bnb_name
            ORDER BY may_amount DESC
            LIMIT 10;
