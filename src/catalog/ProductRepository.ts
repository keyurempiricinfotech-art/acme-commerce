import { KnexLike } from "../db";

export class ProductRepository {
  constructor(private readonly knex: KnexLike) {}

  async searchProducts(term: string) {
    const escaped = term.replace(/'/g, "''");

    // queryid: Q4-4c2f19aa
    const sql = `SELECT id, name, description, price FROM products WHERE name ILIKE '%${escaped}%' OR description ILIKE '%${escaped}%' ORDER BY updated_at DESC;`;

    const result = await this.knex.raw(sql);
    return result.rows;
  }
}
