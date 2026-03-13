@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Landing BLASKU</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Contact</h2>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
            Kelola WhatsApp CTA dan kanal kontak yang akan dipublikasikan ke landing page BLASKU.
        </p>
    </div>

    <span class="status-warning">{{ $contactSetting->whatsapp_display ?: 'Belum diatur' }}</span>
</div>

@include('admin.blasku-landing.partials.subnav')

<section class="panel">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Kontak & CTA WhatsApp</h3>
            <p class="mt-2 text-sm text-slate-500">Data ini dipakai oleh CTA order dan tanya di landing page BLASKU.</p>
        </div>
    </header>

    <div class="panel-body">
        <form method="POST" action="{{ route('admin.blasku-landing.contact.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="field-label" for="contact_whatsapp_number">WhatsApp Number</label>
                    <input id="contact_whatsapp_number" class="field-input" name="whatsapp_number" value="{{ old('whatsapp_number', $contactSetting->whatsapp_number) }}" required>
                </div>
                <div>
                    <label class="field-label" for="contact_whatsapp_display">WhatsApp Display</label>
                    <input id="contact_whatsapp_display" class="field-input" name="whatsapp_display" value="{{ old('whatsapp_display', $contactSetting->whatsapp_display) }}" required>
                </div>
                <div>
                    <label class="field-label" for="contact_whatsapp_cta_text">CTA Text</label>
                    <input id="contact_whatsapp_cta_text" class="field-input" name="whatsapp_cta_text" value="{{ old('whatsapp_cta_text', $contactSetting->whatsapp_cta_text) }}" required>
                </div>
            </div>
            <div>
                <label class="field-label" for="contact_whatsapp_message_template">WhatsApp Message Template Umum</label>
                <textarea id="contact_whatsapp_message_template" class="field-input min-h-[120px]" name="whatsapp_message_template" required>{{ old('whatsapp_message_template', $contactSetting->whatsapp_message_template) }}</textarea>
            </div>
            <div>
                <label class="field-label" for="contact_whatsapp_order_message_template">WhatsApp Order Message Template</label>
                <textarea id="contact_whatsapp_order_message_template" class="field-input min-h-[140px]" name="whatsapp_order_message_template" required>{{ old('whatsapp_order_message_template', $contactSetting->whatsapp_order_message_template ?: 'Halo, saya ingin Tanya & Order BLASKU paket {plan_name} dengan harga {plan_price} / {plan_period}. Mohon info langkah pembayaran dan aktivasinya.') }}</textarea>
                <p class="mt-2 text-xs leading-relaxed text-slate-500">
                    Template ini dipakai tombol <span class="font-semibold text-slate-300">Tanya &amp; Order</span> di landing pricing.
                    Placeholder yang didukung: <span class="code-text text-xs">{plan_name}</span>,
                    <span class="code-text text-xs">{plan_price}</span>,
                    <span class="code-text text-xs">{plan_period}</span>, dan
                    <span class="code-text text-xs">{whatsapp_display}</span>.
                </p>
            </div>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="field-label" for="contact_email">Email</label>
                    <input id="contact_email" class="field-input" name="email" value="{{ old('email', $contactSetting->email) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_instagram_url">Instagram URL</label>
                    <input id="contact_instagram_url" class="field-input" name="instagram_url" value="{{ old('instagram_url', $contactSetting->instagram_url) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_youtube_url">YouTube URL</label>
                    <input id="contact_youtube_url" class="field-input" name="youtube_url" value="{{ old('youtube_url', $contactSetting->youtube_url) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_tiktok_url">TikTok URL</label>
                    <input id="contact_tiktok_url" class="field-input" name="tiktok_url" value="{{ old('tiktok_url', $contactSetting->tiktok_url) }}">
                </div>
            </div>
            <div class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-100">Contoh template order</p>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">
                    Halo, saya ingin Tanya &amp; Order BLASKU paket {plan_name} dengan harga {plan_price} / {plan_period}. Mohon info langkah pembayaran dan aktivasinya.
                </p>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Simpan Kontak</button>
            </div>
        </form>
    </div>
</section>
@endsection
