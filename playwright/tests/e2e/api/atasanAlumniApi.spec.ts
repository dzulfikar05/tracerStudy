import { test, expect } from "@playwright/test";

test("API - mendapatkan daftar atasan alumni", async ({ request }) => {

  // Act
  const response = await request.get("http://localhost:8000/api/superior");

  // Assert status
  expect(response.status()).toBe(200);

  const json = await response.json();

  // Struktur dasar respons
  expect(json).toHaveProperty("status");
  expect(json).toHaveProperty("total");
  expect(json).toHaveProperty("data");
  expect(Array.isArray(json.data)).toBeTruthy();

  // Total minimal 0
  expect(json.total).toBeGreaterThanOrEqual(0);

  // Validasi struktur setiap item data
  for (const item of json.data) {
    expect(item).toHaveProperty("id");
    expect(item).toHaveProperty("full_name");
    expect(item).toHaveProperty("position");
    expect(item).toHaveProperty("phone");
    expect(item).toHaveProperty("email");
    expect(item).toHaveProperty("company_id");
    expect(item).toHaveProperty("passcode");

    // Relasi perusahaan
    if (item.company) {
      expect(item.company).toHaveProperty("id");
      expect(item.company).toHaveProperty("name");
    }
  }
});
