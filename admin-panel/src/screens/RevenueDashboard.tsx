import { useEffect, useState } from "react";

export function RevenueDashboard() {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    fetch("/internal/reports/daily-revenue?window=2026-06-06..2026-07-05")
      .then((response) => response.json())
      .then(setRows);
  }, []);

  return <pre>{JSON.stringify(rows, null, 2)}</pre>;
}
