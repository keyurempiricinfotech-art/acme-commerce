"use client";

import { apiClient } from "../../lib/apiClient";

export default function SearchPage() {
  async function search(term: string) {
    return apiClient(`/products/search?q=${encodeURIComponent(term)}`);
  }

  return <button onClick={() => search("wireless")}>Search</button>;
}
