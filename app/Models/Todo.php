class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // Perbaikan dari 'litle' menjadi 'title'
        'user_id',
        'is_complete',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}