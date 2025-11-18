<?php

namespace App\Livewire\Client\Shared;

use App\Models\InstructorProfile;
use App\Models\StudentProfile;
use App\Services\Client\TraditionalLogin\AuthenticationService;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Account Settings')]
class SettingsBase extends Component
{
    public string $bio;
    public string $aboutMe;
    public array $socialLinks;
    public $user;
    public bool $isDirty = false;
    public $profile;
    public $originalBio;
    public $originalAboutMe;
    public $originalSocialLinks;
    public string $activeTab = 'profile';
    public array $allowedDomains = [
        'facebook' => ['facebook.com'],
        'linkedin' => ['linkedin.com'],
        'github' => ['github.com'],
        'youtube' => ['youtube.com'],
        'website' => [],
    ];

    public array $password = [
        'current' => '',
        'new' => '',
        'confirmation' => '',
    ];

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->profile = $this->user->getProfile;
        if (!$this->profile) {
            if ($this->user->hasRole('instructor')) {
                $this->profile = InstructorProfile::create(
                    ['user_id' => $this->user->id]
                );
            } else {
                $this->profile = StudentProfile::create(['user_id' => $this->user->id]);
            }
        }
        $this->aboutMe = $this->profile->about_me ?? '';
        $this->bio = $this->profile->bio ?? '';
        $this->socialLinks = $this->profile->social_links ?? [];
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

        $this->swalError('Invalid URL', "The provided URL for $platform is not valid. Please check the format.");

        return null;
    }

    public function updatedSocialLinks($value, $key): void
    {
        $this->socialLinks[$key] = $this->validateAndExtract($key, $value);
        $this->checkForChanges();
    }

    public function save(): void
    {
        $changes = [];

        if ($this->bio !== ($this->profile->bio ?? '')) {
            $changes['bio'] = $this->bio;
        }
        if ($this->aboutMe !== ($this->profile->about_me ?? '')) {
            $changes['about_me'] = $this->aboutMe;
        }
        if ($this->socialLinks !== ($this->profile->social_links ?? '')) {
            $changes['social_links'] = $this->socialLinks;
        }

        if (!empty($changes)) {
            $this->profile->updateOrCreate(
                ['user_id' => $this->user->id],
                $changes
            );
            $this->originalAboutMe = $this->aboutMe;
            $this->originalBio = $this->bio;
            $this->originalSocialLinks = $this->socialLinks;
            $this->isDirty = false;
            $this->swal('Settings Saved', 'Your account settings have been updated.');
        }
    }

    public function changePassword(AuthenticationService $authenticationService): void
    {
        $this->validate([
            'password.current' => 'required|min:8',
            'password.new' => 'required|min:8|same:password.confirmation',
            'password.confirmation' => 'required|min:8',
        ], [
            'password.current.required' => 'Current password is required.',
            'password.new.required' => 'New password is required.',
            'password.new.min' => 'New password must be at least 8 characters.',
            'password.new.same' => 'New password and confirmation do not match.',
            'password.confirmation.required' => 'Please confirm your new password.',
            'password.confirmation.min' => 'Confirmation password must be at least 8 characters.',
        ]);

        if (!Hash::check($this->password['current'], $this->user->password)) {
            $this->addError('password.current', 'Current password is incorrect.');
            return;
        }

        if ($authenticationService->changePassword($this->password['new'])) {
            $this->swal('Password Changed', 'Your password has been updated successfully.');
            $this->reset('activeTab');
        } else {
            $this->swalError('Error', 'There was an error updating your password. Please try again.');
        }
    }

    public function forgotPassword(AuthenticationService $authenticationService): void
    {
        $authenticationService->resetPassword(auth()->user());
        $this->swal('Password Reset', 'A new password has been sent to your email address.');
    }

    public function cancel(): void
    {
        $this->aboutMe = $this->originalAboutMe;
        $this->bio = $this->originalBio;
        $this->socialLinks = $this->originalSocialLinks;
        $this->isDirty = false;
    }
}
