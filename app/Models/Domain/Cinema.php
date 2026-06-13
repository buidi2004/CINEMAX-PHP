<?php
namespace App\Models\Domain;

class Cinema extends BaseModel
{
    public int     $id;
    public string  $name;
    public string  $slug;
    public string  $province;
    public string  $district;
    public string  $address;
    public ?string $phone;
    public ?string $email;
    public ?float  $latitude;
    public ?float  $longitude;
    public ?string $imageUrl;
    public string  $openingHours;
    public ?string $description;
    public array   $facilities;  // ['IMAX', '4DX', 'Dolby Atmos', ...]
    public bool    $isActive;
    public string  $createdAt;
    public ?float  $distance = null;
    
    public static function fromArray(array $data): static
    {
        $cinema = new static();
        $cinema->id = (int) $data['id'];
        $cinema->name = $data['name'];
        $cinema->slug = $data['slug'];
        $cinema->province = $data['province'];
        $cinema->district = $data['district'];
        $cinema->address = $data['address'];
        $cinema->phone = $data['phone'] ?? null;
        $cinema->email = $data['email'] ?? null;
        $cinema->latitude = isset($data['latitude']) ? (float) $data['latitude'] : null;
        $cinema->longitude = isset($data['longitude']) ? (float) $data['longitude'] : null;
        $cinema->imageUrl = $data['image_url'] ?? null;
        $cinema->openingHours = $data['opening_hours'] ?? '08:00 - 23:30';
        $cinema->description = $data['description'] ?? null;
        
        // PostgreSQL array to PHP array
        if (isset($data['facilities'])) {
            if (is_string($data['facilities'])) {
                // PostgreSQL array format: {IMAX,4DX,Parking}
                $cinema->facilities = self::parsePostgresArray($data['facilities']);
            } else {
                $cinema->facilities = $data['facilities'];
            }
        } else {
            $cinema->facilities = [];
        }
        
        $cinema->isActive = (bool) ($data['is_active'] ?? true);
        $cinema->createdAt = $data['created_at'];
        
        if (isset($data['distance'])) {
            $cinema->distance = (float) $data['distance'];
        }
        
        return $cinema;
    }
    
    /**
     * Parse PostgreSQL array format to PHP array
     * Input: {IMAX,4DX,Parking} or {"IMAX","4DX","Parking"}
     * Output: ['IMAX', '4DX', 'Parking']
     */
    private static function parsePostgresArray(string $pgArray): array
    {
        if (empty($pgArray) || $pgArray === '{}') {
            return [];
        }
        
        // Remove { and }
        $cleaned = trim($pgArray, '{}');
        
        // Split by comma and clean quotes
        $items = explode(',', $cleaned);
        return array_map(fn($item) => trim($item, '"'), $items);
    }
    
    /**
     * Get Google Maps URL
     */
    public function getMapUrl(): ?string
    {
        if (!$this->latitude || !$this->longitude) {
            return null;
        }
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }
    
    /**
     * Get formatted address for display
     */
    public function getFullAddress(): string
    {
        return $this->address . ', ' . $this->district . ', ' . $this->province;
    }
    
    /**
     * Check if cinema has specific facility
     */
    public function hasFacility(string $facility): bool
    {
        return in_array($facility, $this->facilities);
    }
}
