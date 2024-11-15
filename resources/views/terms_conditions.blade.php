@extends('layouts.header')
@section('content')
<div class="terms-and-conditions">
    <h2>Terms and Conditions</h2>

    <p>
        This document is an electronic record in terms of the Information Technology Act, 2000 and rules
        thereunder, as applicable, and the amended provisions pertaining to electronic records in various
        statutes as amended by the Information Technology Act, 2000. This electronic record is generated
        by a computer system and does not require any physical or digital signatures.
    </p>

    <p>
        This document is published in accordance with the provisions of Rule 3 (1) of the Information
        Technology (Intermediaries guidelines) Rules, 2011. It includes the rules and regulations, privacy
        policy, and terms of use for access or usage of the domain name <strong>arthsutram.co.in</strong>,
        including its related mobile site and application (hereinafter referred to as the “Platform”).
    </p>

    <p>
        The Platform is owned by <strong>ARTHSUTRAM SOLUTION PRIVATE LIMITED</strong>, a company incorporated
        under the Companies Act, 1956, with its registered office in Pune (hereinafter referred to as
        “Platform Owner,” “we,” “us,” or “our”).
    </p>

    <h3>Your Use of the Platform</h3>
    <p>Your use of the Platform and services and tools are governed by the following terms and conditions:</p>
    <ul>
        <li>
            By accessing, browsing, or using the Platform, you indicate your agreement to these terms of use.
            Please read them carefully before proceeding.
        </li>
        <li>
            These terms may be modified at any time without prior notice. It is your responsibility to review
            them periodically for updates.
        </li>
        <li>
            The term "you" or "user" refers to any natural or legal person who has agreed to become a
            user/buyer on the Platform.
        </li>
    </ul>

    <h3>Key Terms of Use</h3>
    <ul>
        <li>
            <strong>Account Information:</strong> You agree to provide true, accurate, and complete information
            during and after registration. You are responsible for all actions taken through your registered account.
        </li>
        <li>
            <strong>No Warranties:</strong> We do not guarantee the accuracy, timeliness, performance, or completeness
            of the information and materials on the Platform.
        </li>
        <li>
            <strong>Use at Your Own Risk:</strong> Your use of the Platform and Services is entirely at your own risk.
            We shall not be liable for any consequences arising from your use.
        </li>
        <li>
            <strong>Intellectual Property:</strong> The contents of the Platform, including design, layout, and graphics,
            are proprietary to us. Unauthorized use may lead to legal action.
        </li>
        <li>
            <strong>Charges:</strong> You agree to pay all charges associated with availing of the Services.
        </li>
        <li>
            <strong>Prohibited Activities:</strong> You agree not to use the Platform for any unlawful or illegal purposes.
        </li>
        <li>
            <strong>Third-party Links:</strong> The Platform may contain links to third-party websites. Upon accessing
            these links, you will be governed by their terms and policies.
        </li>
        <li>
            <strong>Indemnity:</strong> You agree to indemnify and hold harmless the Platform Owner and its affiliates
            against any claims or penalties arising from your breach of these Terms.
        </li>
        <li>
            <strong>Limitation of Liability:</strong> Our liability will not exceed the amount paid by you for the Services
            or ₹100, whichever is less.
        </li>
        <li>
            <strong>Force Majeure:</strong> We are not liable for failure to perform obligations due to events beyond our
            control.
        </li>
        <li>
            <strong>Governing Law:</strong> These Terms shall be governed by and construed in accordance with the laws of India.
        </li>
    </ul>
</div>



<style>
    .terms-and-conditions {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .terms-and-conditions h2 {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .terms-and-conditions h3 {
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .terms-and-conditions p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .terms-and-conditions ul li {
        /* font-size: 16px; */
        line-height: 1.2;
        margin-bottom: 20px;
    }

    /* Media Query for Mobile */
    @media (max-width: 600px) {
        .terms-and-conditions {
            padding: 10px;
        }

        .terms-and-conditions h2 {
            font-size: 20px;
        }

        .terms-and-conditions h3 {
            font-size: 18px;
        }

        .terms-and-conditions p {
            font-size: 14px;
            line-height: 1.5;
        }
    }
</style>
@endsection
