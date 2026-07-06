"use client";

import { apiClient } from "../../lib/apiClient";

export default function LoginPage() {
  async function login(email: string) {
    return apiClient("/auth/login", {
      method: "POST",
      body: JSON.stringify({ email }),
    });
  }

  return <button onClick={() => login("maya@example.com")}>Login</button>;
}
