# workers-python

Python background workers used by the DB performance trace seed.

- Q7: workers/reports/revenue_report.py -> build_daily_revenue() uses SQLAlchemy.
- Q8: workers/sync/inventory_sync.py -> run() uses psycopg style cursor updates.
