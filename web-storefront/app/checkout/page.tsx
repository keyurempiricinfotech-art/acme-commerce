"use client";

import { apiClient } from "../../lib/apiClient";

export default function CheckoutPage() {
  async function submitOrder() {
    await apiClient("/orders/create", {
      method: "POST",
      body: JSON.stringify({
        userId: 9812,
        lines: [
          { sku: "SKU-AX12", warehouseId: 3, quantity: 1 },
          { sku: "SKU-BK44", warehouseId: 3, quantity: 2 },
        ],
      }),
    });
  }

  async function loadPaymentMethods() {
    await apiClient("/checkout/payment", {
      method: "POST",
      body: JSON.stringify({ userId: 9812 }),
    });
  }

  return (
    <main>
      <button onClick={submitOrder}>Place order</button>
      <button onClick={loadPaymentMethods}>Load payment methods</button>
    </main>
  );
}
