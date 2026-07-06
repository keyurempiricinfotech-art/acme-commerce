export async function apiClient(path: string, init?: RequestInit) {
  const response = await fetch(process.env.NEXT_PUBLIC_API_BASE_URL + path, {
    headers: { "content-type": "application/json", ...(init?.headers ?? {}) },
    ...init,
  });

  if (!response.ok) {
    throw new Error(`API request failed: ${response.status}`);
  }

  return response.json();
}
