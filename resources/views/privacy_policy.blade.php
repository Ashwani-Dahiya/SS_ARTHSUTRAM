@extends('layouts.header')
@section('content')

<style>
    .privacy-policy {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .privacy-policy h2 {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .privacy-policy h3 {
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .privacy-policy p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .privacy-policy ul {
        list-style: disc;
        margin: 10px 0;
        padding-left: 10px;
        color: black;
    }

    .privacy-policy li {
        margin-bottom: 10px;
    }

    /* Media Query for Mobile */
    @media (max-width: 600px) {
        .privacy-policy {
            padding: 10px;
        }

        .privacy-policy h2 {
            font-size: 20px;
        }

        .privacy-policy h3 {
            font-size: 18px;
        }

        .privacy-policy p {
            font-size: 14px;
            line-height: 1.5;
        }
    }
</style>

<div class="privacy-policy">
    <h1>Privacy Policy</h1>

    <h2>Introduction</h2>
    <p>
        This Privacy Policy describes how ARTHSUTRAM SOLUTION PRIVATE LIMITED and its affiliates (collectively
        "ARTHSUTRAM SOLUTION PRIVATE LIMITED, we, our, us") collect, use, share, protect, or otherwise process your
        information/personal data through our website <a href="https://arthsutram.co.in/">https://arthsutram.co.in/</a>
        (hereinafter referred to as "Platform").
    </p>
    <p>
        You may browse certain sections of the Platform without registering. We do not offer any product/service under
        this Platform outside India, and your personal data will primarily be stored and processed in India. By using
        this Platform, you agree to be bound by this Privacy Policy, the Terms of Use, and applicable service/product
        terms. If you do not agree, please refrain from using the Platform.
    </p>

    <h2>Collection of Information</h2>
    <p>We collect personal data when you use our Platform, services, or interact with us. The types of information
        collected include, but are not limited to:</p>
    <ul>
        <li>* Personal details such as name, date of birth, address, phone number, email, or proof of identity.</li>
        <li>* Sensitive data such as payment instrument details or biometric information (with your consent).</li>
        <li>* Behavioral, preference, and transactional data related to your use of the Platform.</li>
    </ul>
    <p>
        We may track and analyze information to improve our services. If collected directly by third-party partners, you
        are subject to their privacy policies. We strongly recommend reviewing third-party policies before sharing your
        data.
    </p>
    <p>
        <strong>Note:</strong> ARTHSUTRAM SOLUTION PRIVATE LIMITED will never ask for sensitive data such as your
        debit/credit card PIN or banking passwords. Report any such suspicious activity to law enforcement.
    </p>

    <h2>Usage of Information</h2>
    <p>Your personal data is used to:</p>
    <ul>
        <li>* Provide the services you request.</li>
        <li>* Assist in order fulfillment and enhance customer experience.</li>
        <li>* Resolve disputes and troubleshoot issues.</li>
        <li>* Detect and prevent fraud or unauthorized activities.</li>
        <li>* Customize user experience and conduct research and analysis.</li>
    </ul>
    <p>
        We may also use your data to market our services, but you will always have the option to opt-out of such
        communications.
    </p>

    <h2>Sharing of Information</h2>
    <p>We may share your data with:</p>
    <ul>
        <li>* Group entities and affiliates to provide access to their services and products.</li>
        <li>* Third-party partners such as logistics providers, payment processors, and business partners.</li>
        <li>* Government or law enforcement agencies, as required by law or in good faith to protect rights and safety.
        </li>
    </ul>
    <p>
        Sharing is done to comply with legal obligations, facilitate services, and prevent fraudulent or illegal
        activities.
    </p>

    <h2>Security Precautions</h2>
    <p>
        We adopt reasonable practices to secure your data against unauthorized access or misuse. While we strive to
        protect your data, transmission over the internet may have inherent risks beyond our control. Users are
        responsible for safeguarding their account credentials.
    </p>

    <h2>Data Deletion and Retention</h2>
    <p>
        You can delete your account through the Platform's settings. Deleting your account will result in the loss of
        related data. We may retain certain information to address unresolved claims, prevent fraud, or comply with
        legal obligations.
    </p>
    <p>
        Retained data may be anonymized for research and analytical purposes.
    </p>

    <h2>Your Rights</h2>
    <p>
        You have the right to access, update, and rectify your personal data. Contact us for assistance with these
        requests.
    </p>

    <h2>Consent</h2>
    <p>
        By using our Platform, you consent to the collection, use, and processing of your information as outlined in
        this Privacy Policy. You may withdraw your consent by contacting our Grievance Officer, but withdrawal may
        impact your access to certain services.
    </p>

    <h2>Changes to this Privacy Policy</h2>
    <p>
        We may periodically update this Privacy Policy to reflect changes in our practices. Significant changes will be
        communicated as required under applicable laws.
    </p>
</div>
@endsection
