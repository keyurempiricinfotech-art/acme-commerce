import { adminApi } from "../api";

export function UsersExport() {
  async function exportUsers() {
    const result = await adminApi("/admin/users/export");
    return result;
  }

  return <button onClick={exportUsers}>Export users</button>;
}
