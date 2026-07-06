import { InventoryRepository, OrderLine } from "../inventory/InventoryRepository";
import { OrderRepository } from "../orders/OrderRepository";

export class OrderService {
  constructor(
    private readonly inventoryRepository: InventoryRepository,
    private readonly orderRepository: OrderRepository
  ) {}

  async createOrder(userId: number, lines: OrderLine[]) {
    const stock = await this.inventoryRepository.checkStockForOrder(lines);
    return { userId, stock, accepted: true };
  }

  async listOrders(userId: number) {
    return this.orderRepository.listOrdersForUser(userId);
  }
}
