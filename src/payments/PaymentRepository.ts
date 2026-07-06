import { PrismaClientLike } from "../db";

export class PaymentRepository {
  constructor(private readonly prisma: PrismaClientLike) {}

  async findPaymentMethods(userId: number) {
    // queryid: Q2-b91e02c4
    const sql = `SELECT id, provider, last4, expires_at FROM payments WHERE user_id = ${userId} AND deleted_at IS NULL ORDER BY created_at DESC;`;
    return this.prisma.$queryRawUnsafe(sql);
  }
}
