<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            ['name' => 'Accounts Attributes Information', 'frequency' => 'daily', 'table' => 'accounts_attributes'],
            ['name' => 'Accounts Balances Information', 'frequency' => 'daily', 'table' => 'accounts_balances'],
            ['name' => 'Customer Information', 'frequency' => 'daily', 'table' => 'customer_information'],
            ['name' => 'Deposit Contracts Information', 'frequency' => 'daily', 'table' => 'deposit_contracts'],
            ['name' => 'Loan Contracts Information', 'frequency' => 'daily', 'table' => 'loan_contracts'],
            ['name' => 'Related Party Information', 'frequency' => 'daily', 'table' => 'related_party'],
            ['name' => 'Counterparty Information', 'frequency' => 'daily', 'table' => 'counterparty'],
            ['name' => 'Restructured Loans, Written-Off Loans and Non-Performing Loans (NPLs) Recovery Information', 'frequency' => 'monthly', 'table' => 'restructured_loans'],
            ['name' => 'Collateral Information', 'frequency' => 'monthly', 'table' => 'collateral'],
            ['name' => 'Loan Application Analysis', 'frequency' => 'monthly', 'table' => 'loan_application_analysis'],
            ['name' => 'Securities Information', 'frequency' => 'monthly', 'table' => 'securities'],
            ['name' => 'Forex Purchases and Sales Information', 'frequency' => 'daily', 'table' => 'forex_purchases_sales'],
            ['name' => 'Exchange Rates', 'frequency' => 'daily', 'table' => 'exchange_rates'],
            ['name' => 'Financial Derivatives Information - Options', 'frequency' => 'monthly', 'table' => 'financial_derivatives_options'],
            ['name' => 'Financial Derivatives Information - Futures, Forwards and Swaps', 'frequency' => 'monthly', 'table' => 'financial_derivatives_futures'],
            ['name' => 'Weekly Cash Holdings Information (KES)', 'frequency' => 'weekly', 'table' => 'weekly_cash_holdings'],
            ['name' => 'Weekly Counterfeit Holdings Information (KES)', 'frequency' => 'weekly', 'table' => 'weekly_counterfeit_holdings'],
            ['name' => 'Foreign Exchange Statistics Information', 'frequency' => 'daily', 'table' => 'foreign_exchange_statistics'],
            ['name' => 'Performance of Foreign Subsidiaries of Kenyan Banks', 'frequency' => 'quarterly', 'table' => 'foreign_subsidiaries_performance'],
            ['name' => 'Performance of Foreign Subsidiaries by Economic Activity', 'frequency' => 'quarterly', 'table' => 'foreign_subsidiaries_economic_activity'],
            ['name' => 'Credit Card Facilities Information', 'frequency' => 'monthly', 'table' => 'credit_card_facilities'],
            ['name' => 'Large Cash Transactions (Above 1M)', 'frequency' => 'daily', 'table' => 'large_cash_transactions'],
            ['name' => 'Particulars of Outlets [Places of Business]', 'frequency' => 'quarterly', 'table' => 'outlets_particulars'],
            ['name' => 'Customer Complaints and Remedial Actions', 'frequency' => 'monthly', 'table' => 'customer_complaints'],
            ['name' => 'Terminals (ATM & POS) Information', 'frequency' => 'quarterly', 'table' => 'terminals_information'],
            ['name' => 'Merchants and Payment Agents Information', 'frequency' => 'quarterly', 'table' => 'merchants_payment_agents'],
            ['name' => 'Agent Banking Activities Information', 'frequency' => 'monthly', 'table' => 'agent_banking_activities'],
            ['name' => 'Incidents of Fraud-Theft or Robbery Information', 'frequency' => 'monthly', 'table' => 'fraud_theft_robbery'],
            ['name' => 'Card Acquiring Transaction Information', 'frequency' => 'monthly', 'table' => 'card_acquiring_transactions'],
            ['name' => 'Card Issuer Charges Information', 'frequency' => 'monthly', 'table' => 'card_issuer_charges'],
            ['name' => 'Card Usage Information', 'frequency' => 'monthly', 'table' => 'card_usage'],
            ['name' => 'Card Frauds Information', 'frequency' => 'monthly', 'table' => 'card_frauds'],
            ['name' => 'Particulars of Directors & Management', 'frequency' => 'quarterly', 'table' => 'directors_management'],
            ['name' => 'Staff Information', 'frequency' => 'biannually', 'table' => 'staff_information'],
            ['name' => 'Particulars of Shareholders', 'frequency' => 'biannually', 'table' => 'shareholders_particulars'],
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }
    }
}
