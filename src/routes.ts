import express from "express";
import { OrderController } from "./controllers/OrderController";
import { PaymentController } from "./controllers/PaymentController";
import { AuthController } from "./controllers/AuthController";
import { CatalogController } from "./controllers/CatalogController";
import { AdminUserController } from "./admin/AdminUserController";

export function buildRoutes(controllers: {
  orders: OrderController;
  payments: PaymentController;
  auth: AuthController;
  catalog: CatalogController;
  adminUsers: AdminUserController;
}) {
  const router = express.Router();

  router.post("/orders/create", controllers.orders.create);
  router.post("/checkout/payment", controllers.payments.list);
  router.post("/auth/login", controllers.auth.login);
  router.get("/products/search", controllers.catalog.search);
  router.get("/orders", controllers.orders.list);
  router.get("/categories", controllers.catalog.categories);
  router.get("/admin/users/export", async (_req, res) => res.json(await controllers.adminUsers.exportUsers()));

  return router;
}
