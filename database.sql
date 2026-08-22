-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2026 at 06:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `veganfood_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `servings` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `cuisine`, `cooking_time`, `servings`, `image_url`, `ingredients`, `instructions`, `created_at`) VALUES
(12, 4, 'Chickpea Vegetable Curry', 'Sri Lankan', 35, 4, 'https://th.bing.com/th/id/OIP.pQ2SSbZChhA7QWv2qKvnQwHaJ3?w=203&h=271&c=7&r=0&o=7&pid=1.7&rm=3', '2 cups cooked chickpeas\r\n1 onion (chopped)\r\n2 tomatoes (chopped)\r\n2 cloves garlic (minced)\r\n1 tbsp ginger (grated)\r\n1 cup coconut milk\r\n1 carrot (sliced)\r\n1 cup green beans (chopped)\r\n2 tbsp curry powder\r\n1/2 tsp turmeric\r\n1 tbsp coconut oil\r\nSalt to taste\r\nFresh coriander for garnish', 'Heat coconut oil in a pan.\r\nSauté onion, garlic, and ginger until soft.\r\nAdd tomatoes, curry powder, and turmeric. Cook for 3 minutes.\r\nAdd carrots and green beans. Stir well.\r\nAdd chickpeas and coconut milk.\r\nSimmer for 20 minutes until vegetables are tender.\r\nSeason with salt.\r\nGarnish with fresh coriander.\r\nServe hot with rice or roti.', '2026-07-16 11:59:06'),
(14, 4, 'Vegan Mushroom Fried Rice', 'Asian', 25, 4, 'https://th.bing.com/th/id/OIP.bPpFZHTRHIO77DssMyZBNAHaJl?w=203&h=263&c=7&r=0&o=7&pid=1.7&rm=3', '2 cups cooked rice\r\n1 cup mushrooms (sliced)\r\n1 carrot (diced)\r\n1/2 cup green peas\r\n2 spring onions (chopped)\r\n2 cloves garlic (minced)\r\n2 tbsp soy sauce\r\n1 tbsp sesame oil\r\n1 tbsp vegetable oil\r\nSalt and black pepper to taste', 'Heat vegetable oil in a pan.\r\nSauté garlic until fragrant.\r\nAdd mushrooms, carrots, and peas. Cook for 5 minutes.\r\nAdd the cooked rice and mix well.\r\nStir in soy sauce and sesame oil.\r\nSeason with salt and black pepper.\r\nCook for another 5 minutes.\r\nGarnish with spring onions and serve hot', '2026-07-16 12:44:33'),
(18, 4, 'Creamy Avocado Pasta', 'Italian', 15, 4, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c', '- 200g Pasta\n- 2 Ripe Avocados\n- 2 cloves Garlic (minced)\n- 1 tbsp Olive Oil\n- 1 tbsp Lemon Juice\n- Salt & Black Pepper to taste', '1. Boil pasta in salted water according to package instructions and drain.\n2. In a blender, combine avocados, garlic, olive oil, lemon juice, salt, and pepper until smooth.\n3. Mix the avocado sauce with warm pasta and serve immediately.', '2026-07-22 16:12:18'),
(19, 4, 'Sri Lankan Coconut Dal Curry', 'Sri Lankan', 25, 4, 'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db', '- 1 cup Red Lentils (Dhal)\n- 1 cup Thick Coconut Milk\n- 1 Onion (diced)\n- 2 Green Chilies\n- Curry leaves & Pandan leaf\n- Turmeric, Mustard seeds, Curry powder & Salt', '1. Wash red lentils thoroughly.\n2. Boil lentils with onion, green chilies, turmeric, curry leaves, and 2 cups of water.\n3. Once lentils are soft, stir in coconut milk and simmer for 5 minutes.\n4. Temper mustard seeds in a separate pan and pour over the curry before serving.', '2026-07-22 16:12:18'),
(20, 5, 'Healthy Chickpea Salad', 'Mediterranean / Vegan', 10, 4, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd', '- 1 can Chickpeas (rinsed and drained)\r\n- 1 Cucumber (chopped)\r\n- 1 cup Cherry Tomatoes (halved)\r\n- 1/2 Red Onion (sliced)\r\n- 2 tbsp Olive Oil & Lemon Juice\r\n- Salt and Oregano', '1. In a large bowl, mix chickpeas, cucumber, tomatoes, and red onion.\r\n2. Drizzle with fresh lemon juice and olive oil.\r\n3. Season with salt and oregano, toss well, and serve chilled.', '2026-07-22 16:12:18'),
(21, 5, 'Vegan Mushroom Risotto', 'Italian', 35, 3, 'https://th.bing.com/th/id/OIP.PwU68PTSt5CTQh32n86WywHaLG?w=203&h=304&c=7&r=0&o=7&pid=1.7&rm=3', '- 1 cup Arborio rice\r\n- 200g Mushrooms (sliced)\r\n- 3 cups Vegetable broth\r\n- 1/2 Onion (chopped)\r\n- 2 cloves Garlic\r\n- 2 tbsp Olive oil\r\n- Salt and pepper', '1. Saute onion, garlic, and mushrooms in olive oil.\r\n2. Add Arborio rice and toast for 2 minutes.\r\n3. Gradually add warm vegetable broth, stirring until absorbed.\r\n4. Season with salt and pepper before serving warm.', '2026-07-22 16:14:12'),
(22, 5, 'Tofu Broccoli Stir-Fry', 'Asian', 20, 4, 'https://th.bing.com/th/id/OIP.KqS_3dYvfQj6sfkylOlvJQHaHa?w=203&h=203&c=7&r=0&o=7&pid=1.7&rm=3', '- 250g Firm Tofu (cubed)\r\n- 2 cups Broccoli florets\r\n- 2 tbsp Soy sauce\r\n- 1 tbsp Sesame oil\r\n- 1 tbsp Cornstarch\r\n- 1 tsp Ginger (minced)', '1. Toss tofu cubes in cornstarch and pan-fry until crispy.\r\n2. Saute broccoli and ginger in sesame oil until tender-crisp.\r\n3. Add tofu and soy sauce, toss well for 2 minutes and serve.', '2026-07-22 16:14:12'),
(23, 4, 'Black Bean Vegan Tacos', 'Mexican', 15, 3, 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47', '- 4 Corn tortillas\n- 1 can Black beans (drained)\n- 1 Avocado (sliced)\n- 1/2 cup Salsa\n- Fresh Cilantro & Lime juice', '1. Warm tortillas in a dry skillet.\n2. Heat black beans with spices in a pan.\n3. Assemble tacos with black beans, avocado slices, salsa, and fresh cilantro.', '2026-07-22 16:14:12'),
(24, 5, 'Lentil Shepherd Pie', 'British', 45, 4, 'https://th.bing.com/th/id/OIP.XmJI1kjmArPYjKhXPJg-3gHaHa?w=183&h=183&c=7&r=0&o=7&pid=1.7&rm=3', '- 1 cup Brown lentils (cooked)\r\n- 3 Potatoes (mashed with plant milk)\r\n- 1 cup Mixed veggies (carrots, peas, corn)\r\n- 1 tbsp Tomato paste\r\n- Vegetable stock', '1. Cook lentils, mixed veggies, tomato paste, and stock until thick.\r\n2. Transfer filling to a baking dish.\r\n3. Top with mashed potatoes and bake at 200C for 25 minutes until golden.', '2026-07-22 16:14:12'),
(25, 5, 'Vegan Pad Thai', 'Thai', 25, 4, 'https://th.bing.com/th/id/OIP.FhFmmV8OE-3ou8mjPyNK9QHaLH?w=203&h=304&c=7&r=0&o=7&pid=1.7&rm=3', '- 200g Rice noodles\r\n- 100g Firm Tofu (cubed)\r\n- 1 cup Bean sprouts\r\n- 2 tbsp Tamarind paste\r\n- 2 tbsp Soy sauce\r\n- Crushed peanuts & lime', '1. Soak rice noodles in warm water.\r\n2. Stir-fry tofu until golden.\r\n3. Add noodles, tamarind paste, and soy sauce. Toss with bean sprouts and top with crushed peanuts.', '2026-07-22 16:14:12'),
(26, 5, 'Cauliflower Chickpea Masala', 'Indian', 30, 3, 'https://th.bing.com/th/id/OIP.HEXgmzRSrkPyPcDxMrY6fgHaGt?w=207&h=187&c=7&r=0&o=7&pid=1.7&rm=3', '- 2 cups Cauliflower florets\r\n- 1 can Chickpeas\r\n- 1 cup Tomato puree\r\n- 1/2 cup Coconut milk\r\n- 1 tbsp Garam Masala & Turmeric', '1. Saute spices, onions, and garlic in oil.\r\n2. Stir in tomato puree, cauliflower, and chickpeas.\r\n3. Add coconut milk and simmer for 20 minutes until cauliflower is tender.', '2026-07-22 16:14:12'),
(27, 4, 'Roasted Sweet Potato Bowl', 'American', 30, 4, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd', '- 2 Sweet potatoes (cubed)\n- 1 cup Quinoa (cooked)\n- 1 cup Kale (chopped)\n- 2 tbsp Tahini dressing\n- Olive oil & cumin', '1. Toss sweet potatoes with olive oil and cumin, roast at 200C for 25 mins.\n2. Steam kale lightly.\n3. Assemble bowl with cooked quinoa, sweet potatoes, kale, and drizzle with tahini.', '2026-07-22 16:14:12'),
(28, 5, 'Crispy Falafel Wrap', 'Middle Eastern', 20, 3, 'https://th.bing.com/th/id/OIP.0rZkD6wXKV87T1qFKJHetAHaHa?w=213&h=213&c=7&r=0&o=7&pid=1.7&rm=3', '- 4 Baked or fried Falafels\r\n- 1 Flatbread or pita\r\n- Cucumber & Tomato slices\r\n- Shredded Lettuce\r\n- Tahini sauce', '1. Warm the flatbread.\r\n2. Layer lettuce, cucumber, tomato, and crushed falafel balls.\r\n3. Drizzle with tahini sauce and roll tightly.', '2026-07-22 16:14:12'),
(29, 4, 'Spinach and Potato Curry', 'Sri Lankan', 20, 4, 'https://images.unsplash.com/photo-1610057099443-fde8c4d50f91', '- 2 Potatoes (boiled & cubed)\n- 2 cups Fresh Spinach\n- 1/2 cup Thin coconut milk\n- 1/2 cup Thick coconut milk\n- Mustard seeds, Curry powder, Salt', '1. Cook boiled potatoes with thin coconut milk and spices for 5 minutes.\n2. Add fresh spinach leaves and cook until wilted.\n3. Stir in thick coconut milk, simmer for 2 minutes, and remove from heat.', '2026-07-22 16:14:12'),
(30, 5, 'Classic Vegan Minestrone', 'Italian', 30, 3, 'https://th.bing.com/th/id/OIP.JM4zNylVBlX97HAJsglEBwHaKX?w=203&h=284&c=7&r=0&o=7&pid=1.7&rm=3', '- 1/2 cup Small pasta\r\n- 1 can Kidney beans\r\n- 1 Zucchini & Carrot (diced)\r\n- 4 cups Vegetable broth\r\n- 1 can Diced tomatoes', '1. Saute carrots, zucchini, and garlic in olive oil.\r\n2. Add diced tomatoes, vegetable broth, and kidney beans.\r\n3. Add pasta and cook until tender. Serve hot with herbs.', '2026-07-22 16:14:12'),
(31, 5, 'Teriyaki Eggplant Rice Bowl', 'Japanese', 20, 4, 'https://th.bing.com/th/id/OIP.DLPFKY81aSremKlbCHoR1QHaGL?w=203&h=170&c=7&r=0&o=7&pid=1.7&rm=3', '- 1 Large Eggplant (cubed)\r\n- 2 tbsp Teriyaki sauce\r\n- 1 cup Cooked Jasmine rice\r\n- Sesame seeds & Green onions', '1. Pan-fry eggplant cubes in sesame oil until soft and brown.\r\n2. Pour teriyaki sauce over eggplant and let glaze.\r\n3. Serve over hot jasmine rice garnished with sesame seeds and green onions.', '2026-07-22 16:14:12'),
(32, 5, 'Fluffy Vegan Banana Pancakes', 'American', 15, 2, 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445', '- 1 Ripe Banana (mashed)\n- 1 cup Flour\n- 1 cup Almond milk\n- 1 tsp Baking powder\n- Maple syrup for serving', '1. Whisk mashed banana, flour, almond milk, and baking powder into a batter.\n2. Pour ladlefuls onto a non-stick skillet over medium heat.\n3. Flip when bubbles appear. Serve warm drizzled with maple syrup.', '2026-07-22 16:14:12'),
(33, 4, 'Sweet Mango Sticky Rice', 'Thai', 25, 2, 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb', '- 1 cup Glutinous sticky rice\n- 1 Ripe Sweet Mango (sliced)\n- 1/2 cup Thick Coconut milk\n- 2 tbsp Sugar & Pinch of salt', '1. Steam sticky rice until cooked.\n2. Heat coconut milk with sugar and salt until dissolved, then mix half into the cooked rice.\n3. Serve sweet sticky rice alongside fresh mango slices and top with remaining coconut milk.', '2026-07-22 16:14:12'),
(34, 5, 'Thai Vegan Green Curry', 'Thai', 30, 2, 'https://th.bing.com/th/id/OIP.T2CPQVy_H_0fZrBWkn2HNwHaLG?w=203&h=304&c=7&r=0&o=7&pid=1.7&rm=3', '- 2 tbsp Vegan Green Curry Paste\r\n- 1 can Coconut milk\r\n- 1 cup Tofu & Bamboo shoots\r\n- Bell peppers & Fresh Basil', '1. Fry green curry paste in 2 tbsp coconut milk until fragrant.\r\n2. Add remaining coconut milk, tofu, bamboo shoots, and peppers.\r\n3. Simmer for 15 minutes and finish with fresh basil leaves.', '2026-07-22 16:14:12'),
(35, 4, 'Mediterranean Stuffed Peppers', 'Mediterranean', 40, 2, 'https://images.unsplash.com/photo-1596797038530-2c107229654b', '- 3 Bell peppers (halved & seeded)\n- 1 cup Cooked Rice\n- 1/2 cup Black olives & Cherry tomatoes\n- Olive oil & Oregano', '1. Mix cooked rice, olives, tomatoes, olive oil, and oregano.\n2. Stuff bell pepper halves generously with the mixture.\n3. Bake at 190C for 30 minutes until peppers are roasted soft.', '2026-07-22 16:14:12'),
(36, 5, 'Crispy Garlic Sesame Tofu', 'Asian', 25, 4, 'https://th.bing.com/th/id/OIP.TggAqnunJ8f-CLc8T4DmdQHaJ4?w=203&h=271&c=7&r=0&o=7&pid=1.7&rm=3', '- 300g Extra firm Tofu (pressed & cubed)\r\n- 2 tbsp Soy sauce & 1 tbsp Maple syrup\r\n- 1 tbsp Sesame seeds\r\n- 2 cloves Garlic (minced)\r\n- 2 tbsp Cornstarch', '1. Coat tofu cubes in cornstarch and pan-fry in oil until golden crispy.\r\n2. In a small pan, simmer garlic, soy sauce, and maple syrup.\r\n3. Toss crispy tofu in sauce and sprinkle heavily with sesame seeds.', '2026-07-22 16:14:12'),
(37, 4, 'Creamy Tomato Basil Soup', 'American', 20, 3, 'https://images.unsplash.com/photo-1547592180-85f173990554', '- 1 can Whole peeled tomatoes\n- 1/2 cup Coconut cream\n- 1/2 cup Fresh Basil leaves\n- 1 Onion & Garlic\n- Vegetable broth', '1. Saute onion and garlic in olive oil.\n2. Add tomatoes and broth, simmer for 15 minutes.\n3. Blend soup smooth, stir in coconut cream and fresh basil before serving.', '2026-07-22 16:14:12'),
(38, 5, 'Sri Lankan Pol Sambol with Toast', 'Sri Lankan', 10, 4, 'https://th.bing.com/th/id/OIP.h4VE5q2gHO6l3IVUBGMvmQHaFV?w=238&h=185&c=7&r=0&o=7&pid=1.7&rm=3', '- 1 cup Freshly grated Coconut\r\n- 1 tbsp Chili powder / Chili flakes\r\n- 1 Small Red onion (finely chopped)\r\n- 1 tbsp Lime juice & Salt', '1. Grind grated coconut, chili powder, red onion, and salt using a mortar and pestle.\r\n2. Squeeze fresh lime juice over the mixture and mix well.\r\n3. Serve freshly made Pol Sambol with toasted bread slices.', '2026-07-22 16:14:12'),
(39, 4, 'Lemon Herb Quinoa Salad', 'Mediterranean', 15, 4, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd', '- 1 cup Cooked Quinoa\n- 1/2 cup Cucumber & Parsley (chopped)\n- 1/4 cup Olive oil & Juice of 1 Lemon\n- Salt and Black pepper', '1. In a bowl, combine cooled quinoa, chopped cucumber, and fresh parsley.\n2. Whisk olive oil, lemon juice, salt, and pepper into a dressing.\n3. Toss salad with dressing and chill before serving.', '2026-07-22 16:14:12'),
(40, 5, 'Dark Chocolate Avocado Mousse', 'Asian', 10, 4, 'https://www.joyfuleatingnutrition.com/joycontent/uploads/2024/11/Chocolate-Avocado-Mousse.jpg', '- 2 Ripe Avocados\r\n- 1/2 cup Cocoa powder\r\n- 1/2 cup Maple syrup\r\n- 1/4 cup Almond milk\r\n- 1 tsp Vanilla extract', '1. Add avocados, cocoa powder, maple syrup, almond milk, and vanilla to a blender.\r\n2. Blend on high until completely smooth and creamy.\r\n3. Chill in small glass bowls for 30 minutes before serving as a rich vegan dessert.', '2026-07-22 16:14:12'),
(41, 5, 'Sri Lankan Creamy Pumpkin Curry', 'Sri Lankan', 25, 4, 'images/uploads/1784829972_6a625814071bf.jpg', '- 500g Pumpkin (peeled and cut into cubes)\r\n- 1 cup Thin coconut milk\r\n- 1 cup Thick coconut milk\r\n- 1 Small Onion (sliced)\r\n- 2 Green chilies (sliced)\r\n- 2 cloves Garlic (minced)\r\n- 1 tsp Roasted curry powder\r\n- 1/2 tsp Turmeric powder\r\n- 1/2 tsp Fenugreek seeds\r\n- Curry leaves & Pandan leaf (Rampe)\r\n- Salt to taste', '1. Place diced pumpkin cubes, onion, green chilies, garlic, curry powder, turmeric, fenugreek seeds, curry leaves, and pandan leaf into a cooking pot.\r\n2. Pour in the thin coconut milk and cook over medium heat for 12-15 minutes until the pumpkin becomes soft and tender.\r\n3. Stir in the thick coconut milk and add salt to taste.\r\n4. Reduce the heat to low and gently simmer for another 3-5 minutes until the gravy turns rich and creamy.\r\n5. Remove from heat and serve hot with steamed red rice or roti.', '2026-07-23 18:06:12'),
(42, 5, 'Creamy Avocado Basil Pasta', 'Italian', 15, 4, 'images/uploads/1784830674_6a625ad25a6a4.jpg', '- 200g Spaghetti or Penne Pasta\r\n- 1 Ripe Avocado (scooped)\r\n- 1 cup Fresh Basil leaves\r\n- 2 cloves Garlic\r\n- 2 tbsp Olive oil\r\n- 1 tbsp Lemon juice\r\n- Salt & Black pepper to taste\r\n- 1/2 cup Cherry tomatoes (halved for topping)', '1. Boil pasta in salted water according to package instructions until al dente. Drain and keep aside.\r\n2. In a food processor or blender, blend avocado, fresh basil, garlic, olive oil, lemon juice, salt, and pepper until smooth and creamy.\r\n3. Toss the cooked warm pasta together with the creamy avocado sauce until evenly coated.\r\n4. Top with halved cherry tomatoes and fresh basil leaves before serving.', '2026-07-23 18:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(4, 'vihanga3', 'test3@gmail.com', '$2y$10$bQ8F.MtEoCEE.0HH.uY51O/Dvg7JiSfMu7ukUirAr0yD25WecEBpe', '2026-07-16 11:36:26', 'user'),
(5, 'vihanga', 'test2@gmail.com', '$2y$10$7NOiNmwFdvjE3nN.4luhZueZIM.sOfKRs8OEeqkq3BRYhzmthjyam', '2026-07-22 15:39:56', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_user` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recipe_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `fk_recipe_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
