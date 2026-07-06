import { OrderService } from "../services/OrderService";

export class OrderController {
  constructor(private readonly orderService: OrderService) {}

  create = async (req: any, res: any) => {
    const result = await this.orderService.createOrder(req.body.userId, req.body.lines);
    res.json(result);
  };

  list = async (req: any, res: any) => {
    const result = await this.orderService.listOrders(Number(req.query.userId));
    res.json(result);
  };
}
