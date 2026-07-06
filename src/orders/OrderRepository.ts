import { TypeOrmDataSourceLike } from "../db";

export class OrderRepository {
  constructor(private readonly dataSource: TypeOrmDataSourceLike) {}

  async listOrdersForUser(userId: number) {
    // queryid: Q5-d82a117e
    const sql = `SELECT o.id, o.created_at, oi.sku, oi.quantity, p.provider FROM orders o JOIN order_items oi ON oi.order_id = o.id LEFT JOIN payments p ON p.order_id = o.id WHERE o.user_id = ${userId} ORDER BY o.created_at DESC LIMIT 100;`;
    return this.dataSource.query(sql);
  }
}
