const KOEN_PRODUCTS = [
  {
    id: 1, name: 'Intense Man', slug: 'intense-man', category: 'homme',
    scentFamily: 'Woody Oriental', price: 899, comparePrice: 1500,
    badge: 'Bestseller', rating: 4.8, reviewCount: 124,
    image: 'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=600&q=80',
    images: [
      'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=600&q=80',
      'https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80',
      'https://images.unsplash.com/photo-1541643600914-78b084683601?w=600&q=80'
    ],
    topNotes: ['Bergamot', 'Black Pepper', 'Cardamom'],
    heartNotes: ['Oud', 'Rose', 'Geranium'],
    baseNotes: ['Sandalwood', 'Musk', 'Amber'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 899}, {ml: 30, price: 2199}],
    scentStory: 'A commanding presence wrapped in dark woods and spice. Intense Man captures the essence of midnight in a desert oasis.',
    description: 'A powerful, long-lasting oil-based perfume that evolves beautifully on the skin. Crafted for the modern man who commands attention.'
  },
  {
    id: 2, name: 'Velvet Rose', slug: 'velvet-rose', category: 'femme',
    scentFamily: 'Floral', price: 799, comparePrice: 1200,
    badge: 'New', rating: 4.9, reviewCount: 86,
    image: 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80',
    images: [
      'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80',
      'https://images.unsplash.com/photo-1590736704728-f4730bb30770?w=600&q=80'
    ],
    topNotes: ['Pink Pepper', 'Litchi'],
    heartNotes: ['Damask Rose', 'Peony'],
    baseNotes: ['White Musk', 'Vanilla'],
    sizes: [{ml: 5, price: 449}, {ml: 10, price: 799}, {ml: 30, price: 1899}],
    scentStory: 'The morning dew on a blooming rose garden, bottled in its purest form.',
    description: 'An elegant and sophisticated scent that lingers for over 12 hours.'
  },
  {
    id: 3, name: 'Saffron Dusk', slug: 'saffron-dusk', category: 'homme',
    scentFamily: 'Spicy', price: 949, comparePrice: 1600,
    badge: 'Limited Edition', rating: 4.7, reviewCount: 42,
    image: 'https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80'],
    topNotes: ['Saffron', 'Cinnamon'],
    heartNotes: ['Leather', 'Violet'],
    baseNotes: ['Tobacco', 'Vetiver'],
    sizes: [{ml: 5, price: 549}, {ml: 10, price: 949}, {ml: 30, price: 2399}],
    scentStory: 'A smoky, spicy trail that mirrors the golden hour of an Indian evening.',
    description: 'Bold, mysterious, and deeply evocative.'
  },
  {
    id: 4, name: 'Midnight Jasmine', slug: 'midnight-jasmine', category: 'femme',
    scentFamily: 'Floral Oriental', price: 849, comparePrice: 1400,
    badge: '', rating: 4.6, reviewCount: 95,
    image: 'https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=600&q=80'],
    topNotes: ['Neroli', 'Mandarin'],
    heartNotes: ['Jasmine', 'Orange Blossom'],
    baseNotes: ['Vanilla', 'Cashmere Wood'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 849}, {ml: 30, price: 2099}],
    scentStory: 'The intoxicating aroma of night-blooming jasmine under a moonlit sky.',
    description: 'Sensual and radiant, a true masterpiece of floral artistry.'
  },
  {
    id: 5, name: 'Royal Oud', slug: 'royal-oud', category: 'homme',
    scentFamily: 'Woody', price: 1299, comparePrice: 2000,
    badge: 'Premium', rating: 5.0, reviewCount: 56,
    image: 'https://images.unsplash.com/photo-1547332080-60b69a84a605?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1547332080-60b69a84a605?w=600&q=80'],
    topNotes: ['Lemon', 'Pink Berry'],
    heartNotes: ['Cedar', 'Angelica Root'],
    baseNotes: ['Oud', 'Sandalwood'],
    sizes: [{ml: 5, price: 699}, {ml: 10, price: 1299}, {ml: 30, price: 3200}],
    scentStory: 'The ultimate expression of luxury, featuring the finest oud from Assam.',
    description: 'A scent of power, heritage, and timeless elegance.'
  },
  {
    id: 6, name: 'Citrus Bloom', slug: 'citrus-bloom', category: 'femme',
    scentFamily: 'Fresh', price: 699, comparePrice: 1000,
    badge: 'Popular', rating: 4.5, reviewCount: 78,
    image: 'https://images.unsplash.com/photo-1512290923902-8a9f81dc2069?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1512290923902-8a9f81dc2069?w=600&q=80'],
    topNotes: ['Grapefruit', 'Lemon'],
    heartNotes: ['Magnolia', 'Lily of the Valley'],
    baseNotes: ['White Woods', 'Musk'],
    sizes: [{ml: 5, price: 399}, {ml: 10, price: 699}, {ml: 30, price: 1699}],
    scentStory: 'A burst of sunshine and fresh blossoms to brighten your day.',
    description: 'Light, airy, and effortlessly beautiful.'
  },
  {
    id: 7, name: 'Amber Glow', slug: 'amber-glow', category: 'homme',
    scentFamily: 'Oriental', price: 899, comparePrice: 1500,
    badge: '', rating: 4.8, reviewCount: 110,
    image: 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=600&q=80'],
    topNotes: ['Nutmeg', 'Coriander'],
    heartNotes: ['Amber', 'Vanilla'],
    baseNotes: ['Patchouli', 'Benzoin'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 899}, {ml: 30, price: 2199}],
    scentStory: 'A warm, resinous embrace that glows with inner fire.',
    description: 'Deeply comforting and irresistibly magnetic.'
  },
  {
    id: 8, name: 'Ocean Mist', slug: 'ocean-mist', category: 'homme',
    scentFamily: 'Aquatic', price: 749, comparePrice: 1200,
    badge: 'Summer Favorite', rating: 4.4, reviewCount: 65,
    image: 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1541643600914-78b084683601?w=600&q=80'],
    topNotes: ['Sea Salt', 'Lime'],
    heartNotes: ['Sage', 'Seaweed'],
    baseNotes: ['Driftwood', 'Ambrette Seed'],
    sizes: [{ml: 5, price: 449}, {ml: 10, price: 749}, {ml: 30, price: 1849}],
    scentStory: 'The crisp, salty air of the Indian Ocean at dawn.',
    description: 'Refreshing, clean, and perfectly balanced.'
  },
  {
    id: 9, name: 'Mystic Sandalwood', slug: 'mystic-sandalwood', category: 'homme',
    scentFamily: 'Woody', price: 999, comparePrice: 1700,
    badge: '', rating: 4.9, reviewCount: 88,
    image: 'https://images.unsplash.com/photo-1600080972464-8e5f35802d3e?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1600080972464-8e5f35802d3e?w=600&q=80'],
    topNotes: ['Cardamom', 'Cypress'],
    heartNotes: ['Sandalwood', 'Cedar'],
    baseNotes: ['Vetiver', 'Papyrus'],
    sizes: [{ml: 5, price: 549}, {ml: 10, price: 999}, {ml: 30, price: 2499}],
    scentStory: 'Sacred woods and ancient rituals distilled into a contemporary classic.',
    description: 'Creamy, woody, and meditative.'
  },
  {
    id: 10, name: 'Vanilla Sky', slug: 'vanilla-sky', category: 'femme',
    scentFamily: 'Gourmand', price: 799, comparePrice: 1300,
    badge: 'Sweet', rating: 4.7, reviewCount: 156,
    image: 'https://images.unsplash.com/photo-1503236823255-94609f598e71?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1503236823255-94609f598e71?w=600&q=80'],
    topNotes: ['Almond', 'Coffee'],
    heartNotes: ['Vanilla Orchid', 'Jasmine'],
    baseNotes: ['Tonka Bean', 'Cacao'],
    sizes: [{ml: 5, price: 449}, {ml: 10, price: 799}, {ml: 30, price: 1899}],
    scentStory: 'A decadent journey through clouds of vanilla and dark chocolate.',
    description: 'Irresistibly sweet and cozy.'
  },
  {
    id: 11, name: 'Golden Patchouli', slug: 'golden-patchouli', category: 'femme',
    scentFamily: 'Earthy', price: 899, comparePrice: 1500,
    badge: '', rating: 4.6, reviewCount: 42,
    image: 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&q=80'],
    topNotes: ['Mandarin', 'Bergamot'],
    heartNotes: ['Patchouli', 'White Rose'],
    baseNotes: ['Oakmoss', 'Amber'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 899}, {ml: 30, price: 2199}],
    scentStory: 'The richness of the earth meet the brightness of the sun.',
    description: 'Sophisticated, earthy, and long-lasting.'
  },
  {
    id: 12, name: 'Neroli Night', slug: 'neroli-night', category: 'femme',
    scentFamily: 'Floral', price: 749, comparePrice: 1200,
    badge: '', rating: 4.5, reviewCount: 38,
    image: 'https://images.unsplash.com/photo-1563170351-be82bc888bb4?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1563170351-be82bc888bb4?w=600&q=80'],
    topNotes: ['Neroli', 'Petitgrain'],
    heartNotes: ['Orange Blossom', 'Ylang-Ylang'],
    baseNotes: ['Musk', 'Vetiver'],
    sizes: [{ml: 5, price: 449}, {ml: 10, price: 749}, {ml: 30, price: 1849}],
    scentStory: 'A sparkling floral bouquet captured at its peak.',
    description: 'Radiant, fresh, and feminine.'
  },
  {
    id: 13, name: 'Discovery Set', slug: 'discovery-set', category: 'gifts',
    scentFamily: 'Mixed', price: 1499, comparePrice: 2500,
    badge: 'Gift Choice', rating: 4.9, reviewCount: 320,
    image: 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1557170334-a9632e77c6e4?w=600&q=80'],
    topNotes: ['Multiple'],
    heartNotes: ['Multiple'],
    baseNotes: ['Multiple'],
    sizes: [{ml: 2, price: 1499}],
    scentStory: 'Can\'t decide? Explore our top 5 bestsellers in 2ml vials.',
    description: 'The perfect introduction to the world of Koen.'
  },
  {
    id: 14, name: 'The Royal Collection', slug: 'royal-collection', category: 'gifts',
    scentFamily: 'Oud & Wood', price: 3499, comparePrice: 5000,
    badge: 'Luxury', rating: 5.0, reviewCount: 15,
    image: 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80'],
    topNotes: ['Multiple'],
    heartNotes: ['Multiple'],
    baseNotes: ['Multiple'],
    sizes: [{ml: 10, price: 3499}],
    scentStory: 'Three 10ml bottles of our most prestigious scents.',
    description: 'The ultimate gift for the connoisseur.'
  },
  {
    id: 15, name: 'Morning Dew', slug: 'morning-dew', category: 'femme',
    scentFamily: 'Fresh', price: 649, comparePrice: 900,
    badge: '', rating: 4.3, reviewCount: 45,
    image: 'https://images.unsplash.com/photo-1543472851-0731f295e807?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1543472851-0731f295e807?w=600&q=80'],
    topNotes: ['Apple', 'Cucumber'],
    heartNotes: ['Violet Leaf', 'Rose'],
    baseNotes: ['White Musk', 'Cedar'],
    sizes: [{ml: 5, price: 349}, {ml: 10, price: 649}, {ml: 30, price: 1599}],
    scentStory: 'The freshness of a new day, captured in a bottle.',
    description: 'Crisp, clean, and rejuvenating.'
  },
  {
    id: 16, name: 'Spiced Leather', slug: 'spiced-leather', category: 'homme',
    scentFamily: 'Leather', price: 899, comparePrice: 1500,
    badge: '', rating: 4.7, reviewCount: 52,
    image: 'https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80'],
    topNotes: ['Cardamom', 'Cumin'],
    heartNotes: ['Leather', 'Saffron'],
    baseNotes: ['Patchouli', 'Oud'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 899}, {ml: 30, price: 2199}],
    scentStory: 'A rugged yet refined scent that speaks of adventure.',
    description: 'Bold leather notes with a spicy heart.'
  },
  {
    id: 17, name: 'Floral Muse', slug: 'floral-muse', category: 'femme',
    scentFamily: 'Floral', price: 799, comparePrice: 1300,
    badge: '', rating: 4.6, reviewCount: 74,
    image: 'https://images.unsplash.com/photo-1590736704728-f4730bb30770?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1590736704728-f4730bb30770?w=600&q=80'],
    topNotes: ['Peony', 'Freesia'],
    heartNotes: ['Rose', 'Magnolia'],
    baseNotes: ['Cedar', 'Amber'],
    sizes: [{ml: 5, price: 449}, {ml: 10, price: 799}, {ml: 30, price: 1899}],
    scentStory: 'An inspiring blend of the world\'s most beautiful flowers.',
    description: 'Timeless, romantic, and elegant.'
  },
  {
    id: 18, name: 'Dark Musk', slug: 'dark-musk', category: 'homme',
    scentFamily: 'Musky', price: 849, comparePrice: 1400,
    badge: '', rating: 4.5, reviewCount: 63,
    image: 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1557170334-a9632e77c6e4?w=600&q=80'],
    topNotes: ['Incense', 'Plum'],
    heartNotes: ['White Honey', 'Black Musk'],
    baseNotes: ['Sandalwood', 'Patchouli'],
    sizes: [{ml: 5, price: 499}, {ml: 10, price: 849}, {ml: 30, price: 2099}],
    scentStory: 'A deep, mysterious musk that intrigues the senses.',
    description: 'Sensual, dark, and long-lasting.'
  },
  {
    id: 19, name: 'Travel Trio', slug: 'travel-trio', category: 'gifts',
    scentFamily: 'Various', price: 2199, comparePrice: 3000,
    badge: 'New', rating: 4.8, reviewCount: 28,
    image: 'https://images.unsplash.com/photo-1583445013765-48c2201c8042?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1583445013765-48c2201c8042?w=600&q=80'],
    topNotes: ['Multiple'],
    heartNotes: ['Multiple'],
    baseNotes: ['Multiple'],
    sizes: [{ml: 10, price: 2199}],
    scentStory: 'Your favorite Koen scents, now ready for any journey.',
    description: 'Three 10ml rollerballs in a luxury pouch.'
  },
  {
    id: 20, name: 'Atelier Signature', slug: 'atelier-signature', category: 'homme',
    scentFamily: 'Woody Spicy', price: 1599, comparePrice: 2500,
    badge: 'Founder\'s Pick', rating: 5.0, reviewCount: 12,
    image: 'https://images.unsplash.com/photo-1616948055600-a12117d86301?w=600&q=80',
    images: ['https://images.unsplash.com/photo-1616948055600-a12117d86301?w=600&q=80'],
    topNotes: ['Truffle', 'Gardenia'],
    heartNotes: ['Orchid', 'Spices'],
    baseNotes: ['Mexican Chocolate', 'Patchouli'],
    sizes: [{ml: 30, price: 1599}],
    scentStory: 'The pinnacle of our craft. A scent that defines the Koen legacy.',
    description: 'Exquisite, complex, and unforgettable.'
  }
];

const KOEN_COUPONS = [
  { code: 'KOEN10', type: 'percent', value: 10, minOrder: 500 },
  { code: 'WELCOME20', type: 'percent', value: 20, minOrder: 0 },
  { code: 'FLAT100', type: 'fixed', value: 100, minOrder: 799 }
];

const KOEN_USERS = [
  { id: 1, name: 'Admin', email: 'admin@koen.in', password: 'admin123', isAdmin: true },
  { id: 2, name: 'Priya Sharma', email: 'priya@gmail.com', password: 'test123', isAdmin: false }
];

const MOCK_ORDERS = [
  {
    id: 'KN1712345678',
    date: '2024-03-15T10:30:00Z',
    items: [
      { id: '1-10', name: 'Intense Man', size: '10ml', price: 899, qty: 1, image: 'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=600&q=80' }
    ],
    total: 978, // 899 + 79 shipping
    status: 'Delivered',
    address: { name: 'Priya Sharma', email: 'priya@gmail.com', phone: '9876543210', address1: '123, Rose Garden', city: 'Mumbai', state: 'Maharashtra', pincode: '400001' }
  },
  {
    id: 'KN1712349000',
    date: '2024-03-20T14:20:00Z',
    items: [
      { id: '2-10', name: 'Velvet Rose', size: '10ml', price: 799, qty: 1, image: 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80' },
      { id: '10-10', name: 'Vanilla Sky', size: '10ml', price: 799, qty: 1, image: 'https://images.unsplash.com/photo-1503236823255-94609f598e71?w=600&q=80' }
    ],
    total: 1677, // 1598 + 79
    status: 'Shipped',
    address: { name: 'Priya Sharma', email: 'priya@gmail.com', phone: '9876543210', address1: '123, Rose Garden', city: 'Mumbai', state: 'Maharashtra', pincode: '400001' }
  }
];

function seedLocalStorage() {
  if (!localStorage.getItem('koen_seeded')) {
    localStorage.setItem('koen_orders', JSON.stringify(MOCK_ORDERS));
    localStorage.setItem('koen_seeded', '1');
  }
}
// Load custom products from localStorage if they exist
const OVERRIDE_PRODUCTS = JSON.parse(localStorage.getItem('koen_products_override') || 'null');
if (OVERRIDE_PRODUCTS) {
  KOEN_PRODUCTS.length = 0;
  KOEN_PRODUCTS.push(...OVERRIDE_PRODUCTS);
}

seedLocalStorage();
