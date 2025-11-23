import { test, expect } from "@playwright/test";

test("Halaman Atasan Alumni tampil dengan benar", async ({ page }) => {

    // 1. BUKA HALAMAN LOGIN
    await page.goto("http://localhost:8000/auth/login");

    // 2. LOGIN SEBAGAI ADMIN
    await page.locator('input[name="email"]').fill("admin@gmail.com");
    await page.locator('input[name="password"]').fill("password");
    await page.locator('button[type="submit"]').click();

    // 3. CEK LOGIN SUKSES → diarahkan ke dashboard
    await page.waitForURL("http://localhost:8000/backoffice/dashboard", {
        timeout: 15000
    });

    // 4. BUKA SIDEBAR: Master Data → Atasan Alumni
    await page.getByText("Master Data", { exact: true }).click();
    await page.getByRole("link", { name: "Atasan Alumni" }).click();

    // 5. TUNGGU HALAMAN TERBUKA TANPA ERROR
    await page.waitForURL("http://localhost:8000/backoffice/superior", {
        timeout: 15000
    });
    await expect(page).toHaveURL(/superior/);

    // 6. CEK HALAMAN UTAMA — pastikan card-body muncul
    await expect(page.locator(".card-body").first()).toBeVisible();

    // 7. CEK: JUMLAH KARTU STATISTIK (Total, Sudah Mengisi, Belum Mengisi)
    const statisticCards = page.locator(".card-body .d-flex");
    await expect(statisticCards).toHaveCount(3);

    // 8. CEK TABEL MUNCUL (id unik)
    await expect(page.locator("#table_superiors")).toBeVisible();

    // 9. CEK TABEL BERISI 4 DATA (tbody rows)
    const rows = page.locator("#table_superiors tbody tr");
    await expect(rows).toHaveCount(4);

    // 10. CEK TOMBOL "Filter"
    await expect(page.getByRole("button", { name: /Filter/i })).toBeVisible();

    // 11. CEK TOMBOL "Muat Ulang"
    await expect(page.getByRole("button", { name: "Muat Ulang" })).toBeVisible();

    // 12. CEK TOMBOL "Export Excel"
    await expect(page.getByRole("link", { name: /Export Excel/i })).toBeVisible();

    // 13. CEK JUDUL HALAMAN
    await expect(page.getByRole("heading", { level: 1, name: "Atasan Alumni" }))
        .toBeVisible();
});
