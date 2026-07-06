QUERY_ID = "Q8-0f4dbb91"


def run(conn, adjustments):
    with conn.cursor() as cur:
        for adjustment in adjustments:
            sql = (
                "UPDATE inventory SET available_quantity = available_quantity - %s, updated_at = now() "
                "WHERE sku = %s AND warehouse_id = %s RETURNING sku, available_quantity;"
            )
            cur.execute(sql, (adjustment.quantity, adjustment.sku, adjustment.warehouse_id))
            yield cur.fetchone()
