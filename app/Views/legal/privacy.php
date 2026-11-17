<?php
use App\Helpers\Format;

$config = require dirname(__DIR__, 2) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<section class="section-padding" style="background-color: var(--bg-surface);">
    <div class="site-container site-container-narrow">
        <span class="overline">Data Governance</span>
        <h1 class="heading-section" style="margin-bottom: 2rem;">Client Privacy & Data Confidentiality Policy</h1>

        <div style="font-size: 1rem; line-height: 1.85; color: var(--text-charcoal); display: flex; flex-direction: column; gap: 1.75rem;">
            <p>
                At <strong>Elite Homez</strong> ("your trust, our responsibility."), we consider the protection of client identity, property particulars, and financial confidentiality to be fundamental to our professional standing. This Privacy Policy sets out the strict standards under which personal and transaction data is collected, handled, and safeguarded.
            </p>

            <h2 style="font-size: 1.4rem; color: var(--navy-primary); margin-top: 1rem;">1. Information We Collect</h2>
            <p>
                We only collect information directly submitted by you during advisory inquiries, property brief submissions, or site viewing requests. This may include your full name, mobile number, email address, residential preferences, and investment parameters. We do not gather personal information through third-party data brokerages.
            </p>

            <h2 style="font-size: 1.4rem; color: var(--navy-primary); margin-top: 1rem;">2. Use of Collected Data</h2>
            <p>
                Data collected is utilized solely to:
            </p>
            <ul style="padding-left: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>Provide personalized real estate advisory and schedule accompanied site visits.</li>
                <li>Conduct necessary title, municipal, and registration due diligence on your behalf.</li>
                <li>Communicate verified property updates matching your specified acquisition brief.</li>
            </ul>

            <h2 style="font-size: 1.4rem; color: var(--navy-primary); margin-top: 1rem;">3. Absolute Discretion & Non-Disclosure</h2>
            <p>
                Elite Homez will never sell, lease, or monetize your contact or acquisition information to third parties, advertising networks, or unauthorized aggregators. Information is shared strictly on a need-to-know basis with legal counsel and municipal authorities during formal contract execution, subject to non-disclosure obligations.
            </p>

            <h2 style="font-size: 1.4rem; color: var(--navy-primary); margin-top: 1rem;">4. Technical Security & Data Storage</h2>
            <p>
                Our infrastructure employs enterprise defense-in-depth measures, including encrypted transmission (HTTPS/TLS), parameterized database queries preventing SQL injection, strict session management, and restricted physical access to advisory records.
            </p>

            <h2 style="font-size: 1.4rem; color: var(--navy-primary); margin-top: 1rem;">5. Contacting the Compliance Desk</h2>
            <p>
                For questions regarding this policy or to request the deletion or update of your stored advisory inquiry, please contact our senior administrative desk at <a href="mailto:advisory@elitehomez.com" style="color: var(--gold-primary); text-decoration: underline;">advisory@elitehomez.com</a>.
            </p>
        </div>
    </div>
</section>
