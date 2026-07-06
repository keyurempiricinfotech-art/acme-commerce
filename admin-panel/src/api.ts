export async function adminApi(path: string) {
  const response = await fetch(process.env.REACT_APP_ADMIN_API_BASE_URL + path);
  if (!response.ok) {
    throw new Error(`Admin API failed: ${response.status}`);
  }
  return response.json();
}
