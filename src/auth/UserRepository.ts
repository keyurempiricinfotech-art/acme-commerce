import { DbClient } from "../db";

export class UserRepository {
  constructor(private readonly db: DbClient) {}

  async findUserByEmail(email: string) {
    // queryid: Q3-a43c88d1
    const sql = `SELECT id, email, password_hash, status FROM users WHERE lower(email) = lower('${email}') LIMIT 1;`;
    const result = await this.db.query(sql);
    return result.rows[0] ?? null;
  }
}
