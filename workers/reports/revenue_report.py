from datetime import date
from sqlalchemy import text

QUERY_ID = "Q7-98f1ab62"


def build_daily_revenue(session, start_date: date, end_date: date):
    sql = text(
        "SELECT date_trunc('day', o.created_at) AS day, "
        "sum(oi.quantity * oi.unit_price) AS revenue "
        "FROM orders o JOIN order_items oi ON oi.order_id = o.id "
        "WHERE o.created_at >= :start_date AND o.created_at < :end_date "
        "GROUP BY 1 ORDER BY 1;"
    )
    return session.execute(sql, {"start_date": start_date, "end_date": end_date}).all()
