<?php

namespace App\Livewire\Client\Business\Dashboard;

use App\Models\OrganizationProfile;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Account Settings')]
class Settings extends Component
{
	public string $bio;
	public string $aboutMe;
	public array $socialLinks;
	public $user;
	public bool $isDirty = false;
	public $originalBio;
	public $originalAboutMe;
	public $originalSocialLinks;
	public array $allowedDomains = [
		'facebook' => ['facebook.com'],
		'linkedin' => ['linkedin.com'],
		'github' => ['github.com'],
		'youtube' => ['youtube.com'],
		'website' => [],
	];


	public function mount(): void
	{
		$this->user = auth()->user();
		$profile = $this->user->organizationProfile;
		$this->aboutMe = $profile->about_me ?? '';
		$this->bio = $profile->bio ?? '';
		$this->socialLinks = json_decode($profile->socials_links, true) ?? [];
		$this->originalAboutMe = $this->aboutMe;
		$this->originalBio = $this->bio;
		$this->originalSocialLinks = $this->socialLinks;
	}

	private function checkForChanges(): void
	{
		$this->isDirty = ($this->aboutMe !== $this->originalAboutMe) ||
			($this->bio !== $this->originalBio) ||
			($this->socialLinks !== $this->originalSocialLinks);
	}

	public function updatedAboutMe(): void
	{
		$this->checkForChanges();
	}

	public function updatedBio(): void
	{
		$this->checkForChanges();
	}

	protected function extractUsernameFromUrl(string $value): string|null
	{
		$path = parse_url($value, PHP_URL_PATH);
		if (!$path) return null;

		return trim($path, '/');
	}

	protected function validateAndExtract(string $platform, string $value): ?string
	{
		if (empty($value)) return null;

		$value = trim($value);

		if ($platform === 'website') {
			return $value;
		}

		if (!str_contains($value, 'http')) {
			return $value;
		}

		if (!$host = parse_url($value, PHP_URL_HOST)) {
			return null;
		}

		if (!isset($this->allowedDomains[$platform])) {
			return null;
		}

		foreach ($this->allowedDomains[$platform] as $allowedDomain) {
			if (str_contains($host, $allowedDomain)) {
				return $this->extractUsernameFromUrl($value);
			}
		}

		return null;
	}

	public function updatedSocialLinks($value, $key): void
	{
		$this->socialLinks[$key] = $this->validateAndExtract($key, $value);
		$this->checkForChanges();
	}

	public function save(): void
	{
		$profile = $this->user->organizationProfile;
		$changes = [];

		if ($this->bio !== ($profile->bio ?? '')) {
			$changes['bio'] = $this->bio;
		}
		if ($this->aboutMe !== ($profile->about_me ?? '')) {
			$changes['about_me'] = $this->aboutMe;
		}
		if (json_encode($this->socialLinks) !== ($profile->socials_links ?? '')) {
			$changes['socials_links'] = $this->socialLinks;
		}

		if (!empty($changes)) {
			OrganizationProfile::updateOrCreate(
				['user_id' => $this->user->id],
				$changes
			);
			$this->originalAboutMe = $this->aboutMe;
			$this->originalBio = $this->bio;
			$this->originalSocialLinks = $this->socialLinks;
			$this->isDirty = false;
			$this->dispatch('swal', [
				'icon' => 'success',
				'title' => 'Settings saved successfully',
				'text' => 'Your account settings have been updated.',
				'timer' => 2000,
				'showConfirmButton' => false,
			]);
		}
	}

	public function cancel(): void
	{
		$this->aboutMe = $this->originalAboutMe;
		$this->bio = $this->originalBio;
		$this->socialLinks = $this->originalSocialLinks;
		$this->isDirty = false;
	}

	#[Layout('components.layouts.dashboard')]
	public function render(): View|Application|Factory
	{
        return view('livewire.client.business.dashboard.setting');
	}
}
