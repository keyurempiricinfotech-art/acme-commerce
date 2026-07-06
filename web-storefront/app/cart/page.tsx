"use client";

export default function CartPage() {
  async function recalcCart() {
    const response = await fetch("/cart/recalc", {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({ cartId: "cart_77b2", userId: "user_9812" }),
    });

    return response.json();
  }

  return <button onClick={recalcCart}>Recalculate cart</button>;
}
