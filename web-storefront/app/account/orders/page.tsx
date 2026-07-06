"use client";

import { apiClient } from "../../../lib/apiClient";

export default function OrdersPage() {
  async function loadOrders() {
    return apiClient("/orders?userId=9812");
  }

  return <button onClick={loadOrders}>Load orders</button>;
}
